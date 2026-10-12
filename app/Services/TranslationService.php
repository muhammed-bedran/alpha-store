<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

/**
 * خدمة الترجمة التلقائية عبر Google Translate (مكتبة Stichoza).
 *
 * لا تحتاج API Key — تستخدم الترجمة المجانية مباشرة.
 * النتائج تُخزَّن في Cache لمدة 30 يوماً لتسريع الترجمات المتكررة.
 *
 * @example
 * // $service = app(TranslationService::class);
 * // $service->translate('ملابس', 'en');  // => "Clothes"
 * // $service->translate('ملابس', 'tr');  // => "Giyim"
 */
class TranslationService
{
    protected GoogleTranslate $translator;

    /**
     * تهيئة مكتبة Google Translate عند إنشاء الخدمة.
     *
     * @example
     * // يُستدعى تلقائياً عند أول استخدام:
     * // app(TranslationService::class);
     */
    public function __construct()
    {
        $this->translator = new GoogleTranslate;
    }

    /**
     * ترجمة نص من لغة مصدر إلى لغة هدف.
     *
     * @param  string  $text  النص المراد ترجمته (عادةً عربي)
     * @param  string  $targetLang  اللغة المطلوبة (en, tr)
     * @param  string  $sourceLang  اللغة الأصلية (افتراضي: ar)
     *
     * @example
     * // translate('إلكترونيات', 'en', 'ar') => "Electronics"
     * // translate('إلكترونيات', 'ar', 'ar') => "إلكترونيات" (نفس اللغة)
     * // translate('', 'en')                  => "" (نص فارغ)
     */
    public function translate(string $text, string $targetLang, string $sourceLang = 'ar'): ?string
    {
        $text = trim($text);

        if ($text === '' || $sourceLang === $targetLang) {
            return $text;
        }

        $cacheKey = 'trans:' . md5($text . $sourceLang . $targetLang);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $this->translator->setSource($sourceLang);
            $this->translator->setTarget($targetLang);

            $translation = $this->translator->translate($text);
        } catch (ClientException $exception) {
            if ($exception->getResponse()?->getStatusCode() === 429) {
                throw new RuntimeException(
                    'تم تجاوز حد طلبات الترجمة من Google مؤقتاً. انتظر بضع دقائق، أو اكتب الترجمة يدوياً واحفظها.'
                );
            }

            throw new RuntimeException('تعذّرت الترجمة الآن. حاول مرة أخرى لاحقاً أو أدخل الترجمة يدوياً.');
        } catch (Throwable) {
            throw new RuntimeException('تعذّرت الترجمة الآن. حاول مرة أخرى لاحقاً أو أدخل الترجمة يدوياً.');
        }

        if (! is_string($translation) || trim($translation) === '') {
            throw new RuntimeException('فشلت الترجمة.');
        }

        Cache::put($cacheKey, $translation, now()->addDays(30));

        return $translation;
    }
}
