<?php
/**
 * Plugin Name: 100% Image Display Fixer & Safe Loader
 * Description: Fixes image display issues, dynamically resolves domain mismatches, ensures fallback for broken image links without any conflicts.
 * Version: 1.0.0
 * Author: Antigravity AI
 */

if (!defined('ABSPATH')) exit;

class Fix_Image_Display_Plugin {

    private static $uploads_basedir = null;
    private static $uploads_baseurl = null;
    private static $file_map = null;

    public static function init() {
        // Filter content and image tags
        add_filter('the_content', [__CLASS__, 'fix_content_images'], 9999);
        add_filter('post_thumbnail_html', [__CLASS__, 'fix_content_images'], 9999);
        add_filter('wp_get_attachment_url', [__CLASS__, 'filter_image_url'], 9999);
        add_filter('wp_calculate_image_srcset', [__CLASS__, 'fix_srcset'], 9999);

        // Dynamic domain matching based on current HTTP_HOST
        add_filter('option_siteurl', [__CLASS__, 'normalize_domain'], 9999);
        add_filter('option_home', [__CLASS__, 'normalize_domain'], 9999);

        // Inject Zero-Conflict Frontend Auto-Recovery JS & CSS
        add_action('wp_footer', [__CLASS__, 'inject_frontend_fix_script'], 9999);
        add_action('admin_footer', [__CLASS__, 'inject_frontend_fix_script'], 9999);
    }

    public static function normalize_domain($url) {
        if (is_admin()) return $url;
        if (!empty($_SERVER['HTTP_HOST'])) {
            $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            $current_host = $_SERVER['HTTP_HOST'];
            return preg_replace('#^http[s]?://[^/]+#i', $scheme . '://' . $current_host, $url);
        }
        return $url;
    }

    private static function get_file_map() {
        if (self::$file_map !== null) return self::$file_map;

        self::$file_map = [];
        $upload_info = wp_upload_dir();
        self::$uploads_basedir = str_replace('\\', '/', $upload_info['basedir']);
        self::$uploads_baseurl = rtrim($upload_info['baseurl'], '/');

        if (is_dir(self::$uploads_basedir)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(self::$uploads_basedir, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $abs = str_replace('\\', '/', $file->getPathname());
                    $rel = str_replace(self::$uploads_basedir . '/', '', $abs);
                    $fn = strtolower($file->getFilename());
                    self::$file_map[$fn] = $rel;
                }
            }
        }
        return self::$file_map;
    }

    public static function filter_image_url($url) {
        if (empty($url) || !is_string($url)) return $url;

        // Domain normalization
        $url = self::normalize_domain($url);

        // Check if file exists or resolve dynamically
        if (strpos($url, '/wp-content/uploads/') !== false) {
            $url_clean = strtok($url, '?');
            if (preg_match('#/wp-content/uploads/(.+)#i', $url_clean, $m)) {
                $rel_path = $m[1];
                $file_map = self::get_file_map();
                $full_path = self::$uploads_basedir . '/' . $rel_path;

                if (!file_exists($full_path)) {
                    $fn = strtolower(basename($rel_path));
                    if (isset($file_map[$fn])) {
                        return self::$uploads_baseurl . '/' . $file_map[$fn];
                    }
                    // Strip -1, -2, -3 suffixes
                    $path_info = pathinfo($rel_path);
                    $cleaned_name = strtolower(preg_replace('/-\d+$/', '', $path_info['filename']));
                    $ext = isset($path_info['extension']) ? '.' . strtolower($path_info['extension']) : '';
                    $candidate = $cleaned_name . $ext;

                    if (isset($file_map[$candidate])) {
                        return self::$uploads_baseurl . '/' . $file_map[$candidate];
                    }
                }
            }
        }
        return $url;
    }

    public static function fix_content_images($content) {
        if (empty($content) || !is_string($content)) return $content;

        return preg_replace_callback(
            '#(http[s]?://[^"\'\s>]+/wp-content/uploads/[^"\'\s>]+)#i',
            function ($matches) {
                return self::filter_image_url($matches[1]);
            },
            $content
        );
    }

    public static function fix_srcset($sources) {
        if (!is_array($sources)) return $sources;
        foreach ($sources as $width => &$data) {
            if (isset($data['url'])) {
                $data['url'] = self::filter_image_url($data['url']);
            }
        }
        return $sources;
    }

    public static function inject_frontend_fix_script() {
        ?>
        <script id="fix-image-display-js">
        (function() {
            'use strict';

            function handleImageError(img) {
                if (img.dataset.hasHandledError) return;
                img.dataset.hasHandledError = "true";

                var src = img.src || "";
                if (!src) return;

                // Try stripping -1, -2, -3 suffix before extension
                var cleanedSrc = src.replace(/(-\d+)(\.[a-zA-Z0-9]+)(\?.*)?$/, '$2$3');
                if (cleanedSrc !== src) {
                    img.src = cleanedSrc;
                    return;
                }

                // If image fails completely and no file exists, hide image cleanly to avoid broken icon layout
                img.style.display = 'none';
                img.setAttribute('aria-hidden', 'true');
            }

            // Global event capture listener for img load failures (Zero conflict, no jQuery required)
            window.addEventListener('error', function(event) {
                var target = event.target;
                if (target && target.tagName === 'IMG') {
                    handleImageError(target);
                }
            }, true);

            // Check any existing broken images upon load
            document.addEventListener('DOMContentLoaded', function() {
                var imgs = document.getElementsByTagName('img');
                for (var i = 0; i < imgs.length; i++) {
                    var img = imgs[i];
                    if (img.complete && img.naturalWidth === 0) {
                        handleImageError(img);
                    }
                }
            });
        })();
        </script>
        <?php
    }
}

Fix_Image_Display_Plugin::init();
