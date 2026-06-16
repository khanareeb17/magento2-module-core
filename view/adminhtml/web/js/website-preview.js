/**
 * @author    AkStackPro
 * @copyright Copyright (c) 2026 AkStackPro (http://akstackpro.com/)
 * @package   AkStackPro_Core
 */
define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        var $root = $(element);
        var $iframe = $root.find('.akstackpro-portal__iframe');
        var $loader = $root.find('.akstackpro-portal__loader');
        var $fallback = $root.find('.akstackpro-portal__fallback');
        var timeout = config.timeout || 12000;
        var previewSrc = $iframe.data('src');
        var settled = false;

        function showFallback() {
            if (settled) {
                return;
            }
            settled = true;
            $loader.hide();
            $iframe.remove();
            $fallback.prop('hidden', false).show();
        }

        function showIframe() {
            if (settled) {
                return;
            }
            settled = true;
            $loader.hide();
            $iframe.prop('hidden', false).show();
        }

        function startPreview() {
            if (!previewSrc) {
                showFallback();
                return;
            }

            var timer = window.setTimeout(showFallback, timeout);

            $iframe.one('load', function () {
                window.clearTimeout(timer);
                showIframe();
            });

            $iframe.attr('src', previewSrc);
        }

        function schedulePreview() {
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(startPreview, { timeout: 2500 });
            } else {
                window.setTimeout(startPreview, 800);
            }
        }

        schedulePreview();
    };
});
