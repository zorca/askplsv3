<?php

namespace App\Nova;

use Auth;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
 
 
use Sixlive\TextCopy\TextCopy;

use Outhebox\NovaHiddenField\HiddenField;

use OwenMelbz\RadioField\RadioButton;
 
use Waynestate\Nova\CKEditor; 
 
use Media24si\NovaYoutubeField\Youtube;
//use Laravel\Nova\Fields\Image;
use Ctessier\NovaAdvancedImageField\AdvancedImage;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Country;

use Laravel\Nova\Fields\MorphMany;

class FitnessCenter extends Resource
{
    
    public static $group = '2.Categories';

    public static $model = 'App\FitnessCenter';

    public static function label() {

        return 'Fitness Centers';

    }

    public static $title = 'name';
    
 
    public static $search = [
        'id', 'name' , 'city'    , 'type' , 'fitnesscenterkey'
    ];
 
    public function fields(Request $request)
    {
        $loggedintenant = Auth::user()->tenant; 
        $loggedinemail= Auth::user()->email;
        
        if( $loggedinemail == "amitpri@gmail.com"){

            return [

                    MorphMany::make('TopicCategories'),

                    ID::make()->sortable(), 

                    HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                    Text::make('Fitness Center Name','name')->sortable()->rules('required', 'max:100')->hideWhenUpdating(), 

                    Text::make('Fitness Center Name','name')->hideFromIndex()->onlyOnForms()->hideWhenCreating(), 

                    RadioButton::make('Type')
                    ->options([ 
                        'Gym' => 'Gym', ]), 

                    Text::make('Phone1'),
                    Text::make('Phone2'),
                    Text::make('Email1'),
                    Text::make('Email2'),

                    new Panel('Address Information', $this->addressFields()), 

                    Text::make('Website')->hideFromIndex(), 

                    Text::make('Other Links','links')->hideFromIndex(), 

                    CKEditor::make('Details')->options([
                        'height' => 300,
                        'toolbar' => [
                            ['Cut','Copy','Paste'],
                            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                            ['Image','Table','HorizontalRule','SpecialChar','PageBreak'], 
                            ['Bold','Italic','Strike','-','Subscript','Superscript'],
                            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
                            ['JustifyLeft','JustifyCenter','JustifyRight'],
                            ['Link','Unlink'], 
                            ['Format','FontSize','-','Maximize']
                        ],
                    ])->hideFromIndex(),

                //    Image::make('Image', 'profilepic')->disk('public'),
                    AdvancedImage::make('Image', 'profilepic')->disk('public')->croppable()->resize(600,600),

                    Youtube::make('Video')->hideFromIndex(),

                    RadioButton::make('Active', 'status')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('1')->hideFromIndex(), 

                    HiddenField::make('fitnesscenterkey')->default(mt_rand(100000000, 999999999))->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
          
                    TextCopy::make('Public URL' ,function(){

                         return 'https://askpls.com/f/' . $this->fitnesscenterkey;
     
                    })->hideWhenUpdating(), 

                    RadioButton::make('Top')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('0'), 

                    
 
                ];

        }else{

            return [
                
                MorphMany::make('TopicCategories'),

                ID::make()->sortable()->hideFromIndex(), 

                HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                Text::make('Fitness Center Name','name')->sortable()->rules('required', 'max:100')->hideWhenUpdating(), 

                Text::make('Fitness Center Name','name')->hideFromIndex()->onlyOnForms()->hideWhenCreating()->withMeta(['extraAttributes' => [
                          'readonly' => true
                    ]]), 

                RadioButton::make('Type')
                ->options([ 
                    'Gym' => 'Gym', ]), 

                Text::make('Phone1')->onlyOnForms(),
                Text::make('Phone2')->onlyOnForms(),
                Text::make('Email1')->onlyOnForms(),
                Text::make('Email2')->onlyOnForms(),

                new Panel('Address Information', $this->addressFields()), 

                Text::make('Website')->hideFromIndex(), 

                Text::make('Other Links','links')->hideFromIndex(), 

                CKEditor::make('Details')->options([
                    'height' => 300,
                    'toolbar' => [
                        ['Cut','Copy','Paste'],
                        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                        ['Image','Table','HorizontalRule','SpecialChar','PageBreak'], 
                        ['Bold','Italic','Strike','-','Subscript','Superscript'],
                        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
                        ['JustifyLeft','JustifyCenter','JustifyRight'],
                        ['Link','Unlink'], 
                        ['Format','FontSize','-','Maximize']
                    ],
                ])->hideFromIndex(),

             //   Image::make('Image', 'profilepic')->disk('public'),
                AdvancedImage::make('Image', 'profilepic')->disk('public')->croppable()->resize(600,600),

                Youtube::make('Video')->hideFromIndex(),

                RadioButton::make('Active', 'status')
                ->options([ 
                    '0' => 'No',
                    '1' => 'Yes',
                ])->sortable()->default('1')->hideFromIndex(), 

                HiddenField::make('fitnesscenterkey')->default(mt_rand(100000000, 999999999))->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
      
                TextCopy::make('Public URL' ,function(){

                     return 'https://askpls.com/f/' . $this->fitnesscenterkey;
 
                })->hideWhenUpdating(), 
 
            ];
         
        }
    }

    protected function addressFields()
    {
        return [ 
            Text::make('Locality')->hideFromIndex(),
            Place::make('City')->onlyCities()->rules('required', 'max:100'),
            Text::make('State')->hideFromIndex(), 
            Country::make('Country')->hideFromIndex(),
        ];
   
    }
 
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
