<?php

namespace App\Http\Middleware;

use App\Lang\Lang;
use Inertia\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Resources\LanguageResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'language' => app()->getLocale(),
            'translations' => function () {
                return collect(File::allFiles(base_path('lang/' . app()->getLocale())))
                    ->flatMap(function ($file) {
                        return Arr::dot(
                            File::getRequire($file->getRealPath()),
                            $file->getBasename($file->getExtension())
                        );
                    });
            },
            'languages' => LanguageResource::collection(Lang::cases()),
        ];
    }
}
