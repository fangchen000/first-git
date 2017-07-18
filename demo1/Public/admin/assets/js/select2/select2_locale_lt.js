/**
 * Select2 Lithuanian translation.
 * 
 * @author  CRONUS Karmalakas <cronus dot karmalakas at gmail dot com>
 * @author  Uriy Efremochkin <efremochkin@uriy.me>
 */
(function ($) {
    "use strict";

    $.fn.select2.locales['lt'] = {
        formatNoMatches: function () { return "Atitikmenų nerasta"; },
        formatInputTooShort: function (input, min) { return "Įrašykite dar" + character(min - input.length); },
        formatInputTooLong: function (input, max) { return "Pašalinkite" + character(input.length - max); },
        formatSelectionTooBig: function (limit) {
        	return "Jūs galite pasirinkti tik " + limit + " element" + ((limit%99 > 9 && limit%99 < 21) || limit%10 == 0 ? "ų" : limit%10 > 1 ? "us" : "ą");
        },
        formatLoadMore: function (pageNumber) { return "Kraunama daugiau rezultatų…"; },
        formatSearching: function () { return "Ieškoma…"; }
    };

    $.extend($.fn.select2.defaults, $.fn.select2.locales['lt']);

    function character (n) {
        return " " + n + " simbol" + ((n%99 > 9 && n%99 < 21) || n%10 == 0 ? "ių" : n%10 > 1 ? "ius" : "į");
    }
})(jQuery);
