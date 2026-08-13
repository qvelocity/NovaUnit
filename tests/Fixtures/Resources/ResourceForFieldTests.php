<?php

namespace JoshGaber\NovaUnit\Tests\Fixtures\Resources;

use JoshGaber\NovaUnit\Tests\Fixtures\Actions\ActionNoFields;
use JoshGaber\NovaUnit\Tests\Fixtures\Actions\ActionValidFields;
use JoshGaber\NovaUnit\Tests\Fixtures\MockModel;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class ResourceForFieldTests extends Resource
{
    public static $model = MockModel::class;

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Alpha', 'field_alpha')
                ->rules('max:128'),
            Number::make('Beta', 'field_beta')
                ->showOnIndex()->showOnDetail()->showOnCreating()->showOnUpdating(),
            Number::make('Gamma', 'field_gamma')
                ->hideFromIndex()->hideFromDetail()->hideWhenCreating()->hideWhenUpdating(),
            Text::make('Delta', 'field_delta')
                ->nullable()->sortable(),
            Text::make('Epsilon', 'field_epsilon')
                ->creationRules('min:8')
                ->updateRules('min:16'),
            Text::make('Zeta', 'field_zeta')
                ->showOnIndex(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->showOnDetail(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->showOnCreating(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->showOnUpdating(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                }),
            Text::make('Eta', 'field_eta')
                ->hideFromIndex(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->hideFromDetail(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->hideWhenCreating(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                })
                ->hideWhenUpdating(function (NovaRequest $request): bool {
                    return $request->isLensRequest();
                }),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new ActionValidFields(),
            new ActionNoFields(),
        ];
    }
}
