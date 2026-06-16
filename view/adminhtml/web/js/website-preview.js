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
        var timeout = config.timeout || 20000;
        var previewSrc = $iframe.data('src');
        var settled = false;
        var iframeEl = $iframe[0];

        function showFallback() {
            if (settled) {
                return;
            }
            settled = true;
            $loader.attr('hidden', 'hidden');
            $iframe.attr('hidden', 'hidden');
            $fallback.removeAttr('hidden');
        }

        function showIframe() {
            if (settled) {
                return;
            }
            settled = true;
            $loader.attr('hidden', 'hidden');
            $fallback.attr('hidden', 'hidden');
            $iframe.removeClass('akstackpro-portal__iframe--loading').removeAttr('hidden');
        }

        function isLoadedUrl(url) {
            return url && url !== 'about:blank' && url.indexOf('about:') !== 0;
        }

        function startPreview() {
            if (!previewSrc || !iframeEl) {
                showFallback();
                return;
            }

            var timer = window.setTimeout(showFallback, timeout);

            function onLoad() {
                if (!isLoadedUrl(iframeEl.src)) {
                    return;
                }
                window.clearTimeout(timer);
                $iframe.off('load', onLoad);
                showIframe();
            }

            $iframe
                .removeAttr('hidden')
                .addClass('akstackpro-portal__iframe--loading')
                .on('load', onLoad);

            iframeEl.src = previewSrc;
        }

        function schedulePreview() {
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(startPreview, { timeout: 1500 });
            } else {
                window.setTimeout(startPreview, 500);
            }
        }

        schedulePreview();
    };
});
