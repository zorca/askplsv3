<?php

namespace App\Nova;
 
use Auth;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Select;

use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;


use Laravel\Nova\Fields\HasMany;

use App\Nova\Actions\EmailTopicGroup;
use App\Nova\Actions\TestAction;
use Sixlive\TextCopy\TextCopy;

use Outhebox\NovaHiddenField\HiddenField;

use OwenMelbz\RadioField\RadioButton;

use Spatie\TagsField\Tags;
use Waynestate\Nova\CKEditor; 
 
use Media24si\NovaYoutubeField\Youtube;
use R64\NovaImageCropper\ImageCropper;

class Topic extends Resource
{ 

    public static $group = 'Reviews';
    
    public static $model = 'App\Topic';
 
    public static $title = 'topic_name';

    public static $search = [
        
        'id', 'topic_name' , 'type'
    ];
  
    public function fields(Request $request)
    {
        
        $loggedintenant = Auth::user()->tenant; 
        $loggedinemail= Auth::user()->email;

        if( $loggedinemail == "amitpri@gmail.com"){

            return [
                    ID::make()->sortable()->hideFromIndex(), 

                    HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                    Text::make('Topic Name')->sortable()->rules('required', 'max:100')
                            ->help(
                                'The heading of the review being asked for. Max length 100'
                            ),   

                    BelongsTo::make('Category')->rules('required', 'max:100'), 

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
 

                    ImageCropper::make('Image'),

                    Youtube::make('Video'),

                    RadioButton::make('Type')
                    ->options([ 
                        'Public' => 'Public',
                    ])->default('Public')->sortable()->help(
                                "<br><br><i>" . 'Sharable and option to display at askpls.com portal for others to view and review'  ."<i>"
                            ), 

                    RadioButton::make('Searchable', 'sitedisplay')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',                    
                    ])->sortable()->default('1')->hideFromIndex()->help(
                                "<br><br><i>" . 'Sharable and option to display at askpls.com portal for others to view and review'  ."<i>"
                            ),  

                    RadioButton::make('Review Viewable', 'reviewdisplay')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('1')->hideFromIndex()->help(
                                "<br><br><i>" . 'Review Viewable by others at AskPls Portal'  ."<i>"
                            ), 

                    RadioButton::make('Front Display by Admin', 'frontdisplay')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('0')->hideFromIndex(), 

                    RadioButton::make('Active', 'status')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('1'),

                    DateTime::make('Expiry Date', 'displayuptil')->format('DD MMM YYYY, LT')->sortable()->help(
                                "<i>" . 'By default, Topics will be active forever'  ."<i>"
                            )->hideFromIndex(), 

                    HiddenField::make( 'url')->default(mt_rand(100000000, 999999999))->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
          
                    TextCopy::make('Public URL' ,function(){

                        if ( $this->type == 'Public'){

                            return 'https://askpls.com/topics/' . $this->url;
                        }

                    })->hideWhenUpdating(),

                    

              //      Tags::make('Tags')->withoutSuggestions()->hideFromIndex(), 

                    HasMany::make('Review')
                ];

        }else{

            if( $loggedintenant == 0 ){

                return [
                    ID::make()->sortable()->hideFromIndex(), 

                    HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                    Text::make('Topic Name')->sortable()->rules('required', 'max:100')
                            ->help(
                                'The heading of the review being asked for. Max length 100'
                            )->hideWhenUpdating(), 

                    Text::make('Topic Name')->hideFromIndex()->onlyOnForms()->hideWhenCreating()->withMeta(['extraAttributes' => [
                              'readonly' => true
                        ]]), 

                    BelongsTo::make('Category')->rules('required', 'max:100'), 

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

                    ImageCropper::make('Image'),

                    Youtube::make('Video'),

                    RadioButton::make('Type')
                    ->options([ 
                        'Public' => 'Public',
                    ])->default('Public')->sortable()->help(
                                "<br><br><i>" . 'Sharable and option to display at askpls.com portal for others to view and review'  ."<i>"
                            ), 

                    RadioButton::make('Searchable', 'sitedisplay')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',                    
                    ])->sortable()->default('1')->hideFromIndex()->help(
                                "<br><br><i>" . 'Sharable and option to display at askpls.com portal for others to view and review'  ."<i>"
                            ),  

                    RadioButton::make('Review Viewable', 'reviewdisplay')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('1')->hideFromIndex()->help(
                                "<br><br><i>" . 'Review Viewable by others at AskPls Portal'  ."<i>"
                            ),  

                    RadioButton::make('Active', 'status')
                    ->options([ 
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->sortable()->default('1'),

                    DateTime::make('Expiry Date', 'displayuptil')->format('DD MMM YYYY, LT')->sortable()->help(
                                "<i>" . 'By default, Topics will be active forever'  ."<i>"
                            )->hideFromIndex(), 

                    HiddenField::make( 'url')->default(mt_rand(100000000, 999999999))->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
          
                    TextCopy::make('Public URL' ,function(){

                        if ( $this->type == 'Public'){

                            return 'https://askpls.com/topics/' . $this->url;
                        }

                    })->hideWhenUpdating(),

                    

              //      Tags::make('Tags')->withoutSuggestions()->hideFromIndex(), 

                    HasMany::make('Review')
                ];
            }else{

                return [
                    ID::make()->sortable()->hideFromIndex(), 

                    HiddenField::make('User', 'user_id')->current_user_id()->hideFromIndex()->hideFromDetail(),

                    Text::make('Topic Name')->sortable()->rules('required', 'max:100')
                            ->help(
                                'The heading of the review being asked for. Max length 100'
                            ),
                    BelongsTo::make('Category')->rules('required', 'max:100'), 

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

                    ImageCropper::make('Image'),

                    Youtube::make('Video'),

                    HiddenField::make( 'url')->default('https://askpls.com/topics/' . str_random(10))->hideFromIndex()->hideFromDetail(),
          
                    Text::make('Public URL' ,function(){

                        if ( $this->type == 'Public'){

                            return $this->url;
                        }

                    }),


                    BelongsToMany::make('Group'),

                    HasMany::make('Review')
                ];

            }
        }

        

       
    }

 
    public function cards(Request $request)
    {
        return [];
    }

 
    public function filters(Request $request)
    {
        return [];
    }

 
    public function lenses(Request $request)
    {
        return [];
    }

 
    public function actions(Request $request)
    {
        return [

            new EmailTopicGroup, 
        ];
    }
}
