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

class CollegeMember extends Resource
{
    
    public static $group = 'Categories';

    public static $model = 'App\CollegeMember';

    public static $displayInNavigation = false;

    public static $title = 'name';
    
    public static $search = [

        'id', 'name' , 'city' , 'type' ,'collegekey'
    ];

    public function fields(Request $request)
    {
        $loggedintenant = Auth::user()->tenant; 
        $loggedinemail= Auth::user()->email;
        $loggedinrole = Auth::user()->role;
        
        if( $loggedinrole == "super"){

            return [

                    MorphMany::make('TopicCategories'),

                    ID::make()->sortable(), 

                    HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                    Text::make('College Name','name')->sortable()->rules('required', 'max:100')->hideWhenUpdating(), 

                    Text::make('College Name','name')->hideFromIndex()->onlyOnForms()->hideWhenCreating(), 

                    RadioButton::make('Type')
                    ->options([ 
                        'Arts' => 'Arts',
                        'Business' => 'Business',
                        'Commerce' => 'Commerce',
                        'Deemed Universities' => 'Deemed Universities',
                        'Engineering' => 'Engineering',
                        'Fashion' => 'Fashion',
                        'Hospitality' => 'Hospitality',
                        'Journalism' => 'Journalism',
                        'Law' => 'Law',
                        'Medical' => 'Medical', 
                        'Science' => 'Science', 
                        'Others' => 'Others',


                     ])->sortable()->rules('required', 'max:100'), 

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
                    ])->sortable()->default('1')->onlyOnDetail(), 

                    HiddenField::make('collegekey')->default(mt_rand(100000000, 999999999))->hideWhenUpdating(),
          
                    TextCopy::make('Public URL' ,function(){

                            return 'https://askpls.com/c/Colleges/' . $this->collegekey;

                    })->hideWhenUpdating(),

                    
                ];

        }else{

            return [
                MorphMany::make('TopicCategories'),

                ID::make()->sortable()->hideFromIndex(), 

                HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                Text::make('College Name','name')->sortable()->rules('required', 'max:100')->hideWhenUpdating(), 

                Text::make('College Name','name')->hideFromIndex()->onlyOnForms()->hideWhenCreating()->withMeta(['extraAttributes' => [
                          'readonly' => true
                    ]]), 

                RadioButton::make('Type')
                ->options([ 
                        'Arts' => 'Arts',
                        'Business' => 'Business',
                        'Commerce' => 'Commerce',
                        'Deemed Universities' => 'Deemed Universities',
                        'Engineering' => 'Engineering',
                        'Fashion' => 'Fashion',
                        'Hospitality' => 'Hospitality',
                        'Journalism' => 'Journalism',
                        'Law' => 'Law',
                        'Medical' => 'Medical', 
                        'Science' => 'Science', 
                        'Others' => 'Others',
                    ])->sortable()->rules('required', 'max:100'), 

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

                //Image::make('Image', 'profilepic')->disk('public'),
                AdvancedImage::make('Image', 'profilepic')->disk('public')->croppable()->resize(600,600),

                Youtube::make('Video')->hideFromIndex(),

                RadioButton::make('Active', 'status')
                ->options([ 
                    '0' => 'No',
                    '1' => 'Yes',
                ])->sortable()->default('1')->onlyOnDetail(), 

                HiddenField::make('collegekey')->default(mt_rand(100000000, 999999999))->hideWhenUpdating(),
      
                TextCopy::make('Public URL' ,function(){

                        return 'https://askpls.com/c/Colleges/' . $this->collegekey;

                })->hideWhenUpdating(),

                
            ];
         
        }
    }

    protected function addressFields()
    {
        return [             
            Place::make('City')->onlyCities()->sortable()->rules('required', 'max:100'),
            Text::make('Locality')->hideFromIndex(),
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
