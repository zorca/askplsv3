<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="AskPls" />

    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Playfair+Display:700,700i,900" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/style.css" type="text/css" />
    <link rel="stylesheet" href="/css/dark.css" type="text/css" />

    <!-- Home Demo Specific Stylesheet -->
    <link rel="stylesheet" href="/askpls.css" type="text/css" />

    <link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />
 

    <link rel="stylesheet" href="/css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/css/colors.php?color=1c85e8" type="text/css" />

    <script src="/vue/vue.min.js"></script>
        <script src="/axios/axios.min.js"></script>
        @include('analytics')
    <!-- Document Title
    ============================================= -->
    <title>AskPls | Anonymous Review System</title>

</head>

<body class="stretched side-push-panel">

	<div id="side-panel">

        <div id="side-panel-trigger-close" class="side-panel-trigger"><a href="#"><i class="icon-line-cross"></i></a></div>

        <div class="side-panel-wrap">

            <div class="widget clearfix">

                <h4 class="t400">Login</h4>

                
                <div class="line line-sm"></div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="col_full"> 
                        <label for="email" class="t400">{{ __('E-Mail Address') }}</label> 
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col_full">
                        <label for="login-form-password" class="t400">Password:</label>  
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col_full nobottommargin">
                        <button class="button button-rounded t400 nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                        <br>   <br> 
                        <a href="/register" class=" ">Register</a> |       <a href="/password/reset" class=" ">Forgot Password?</a>
                    </div>

                </form>


            </div>

        </div>

    </div>

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header">

            <div id="header-wrap">

                <div class="container clearfix">

                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                    <div class="row justify-content-xl-between justify-content-lg-between clearfix">

                        <div class="col-lg-2 col-12 d-flex align-self-center">
                            <!-- Logo
                            ============================================= -->
                            <div id="logo">
                                <a href="/" class="standard-logo"><img src="/images/logo.png" alt="AskPls"></a>
                                <a href="/" class="retina-logo"><img src="/images/logo@2x.png" alt="AskPls"></a>
                            </div><!-- #logo end -->

                        </div>

                        <div class="col-lg-8 col-12 d-xl-flex d-lg-flex justify-content-xl-center justify-content-lg-center">
                            <!-- Primary Navigation
                            ============================================= -->
                            <nav id="primary-menu" class="with-arrows fnone clearfix">

                                <ul> 
                                    <li><a href="/about"><div>About AskPls</div></a></li>
                                    <li><a href="/t"><div>Topics</div></a></li>  
                                    <li><a href="/faqs"><div>FAQs</div></a></li>
                                    <li><a href="/contact"><div>Contact</div></a></li>
                                </ul>
                            </nav><!-- #primary-menu end -->
                        </div>

                        @if (Route::has('login'))
                            @if (Auth::check())
                                <div class="col-lg-2 d-none d-lg-inline-flex d-xl-inline-flex justify-content-end nomargin">
                                    <!-- Top Search
                                    ============================================= -->
                                    <div id="side-panel-trigger"  > 
                                        
                                        <a href="/portal" class="d-none d-lg-block">Portal <i class="icon-line-arrow-right"></i></a>
                                    </div><!-- #top-search end -->
                                </div> 
                            @else
                                <div class="col-lg-2 d-none d-lg-inline-flex d-xl-inline-flex justify-content-end nomargin">
                                    <!-- Top Search
                                    ============================================= -->
                                    <div id="side-panel-trigger" class="side-panel-trigger">
                                        <a href="#" class="d-block d-lg-none"><i class="icon-line-lock"></i></a>
                                        
                                        <a href="#" class="d-none d-lg-block">Sign In <i class="icon-line-arrow-right"></i></a>
                                    </div><!-- #top-search end -->
                                </div>                           
                            @endif
                        @endif
                        <a href="#" class="d-block d-lg-none mobile-side-panel side-panel-trigger"><i class="icon-line-arrow-right"></i></a>
                    </div>
                </div>

            </div>

        </header><!-- #header end -->

		<!-- Page Title
		============================================= -->

		<div id="viewprofile" style=" margin-top:40px;     "> 
 
		<!-- Content
		============================================= -->
            <div class="container">
    			<section  class="  center" > 

                    <div class="media">
                      <img v-if="profilepic"  :src="'/storage/' + profilepic" width="200">
                      <div class="media-body">
                        <h1 class="font-secondary nott mb-3" style="color: black; font-size: 42px;">@{{ inpName }}</h1>
                        <p style="font-weight: 300; opacity: .7; color: black;  ">@{{inpAddress}} </p>
                    <p style="font-weight: 300; opacity: .7; color: black;  ">@{{inpLocality}} &nbsp; @{{inpCity}} &nbsp; @{{inpCountry}} </p>
                      </div>
                    </div>
 

                    <p v-if="categorytype == 'Doctors'" style="font-weight: 600; opacity: 1; color: black;  ">@{{inpSpeciality}} </p>
                    <p v-if="categorytype == 'Hotels'" style="font-weight: 600; opacity: 1; color: black;  ">@{{inpType}} </p>
                    <p v-if="categorytype == 'Restaurants'" style="font-weight: 600; opacity: 1; color: black;  ">@{{inpType}} </p>

                    <p v-if="categorytype == 'Doctors'" style="font-weight: 600; opacity: 1; color: black;  ">@{{inpQualification}}, &nbsp;  @{{inpExp}} yrs experience </p>

                         
     
                    <div class="content-wrap clearfix" style="margin-top: -50px;">

                        <div class="row clearfix" >
                            <h4 style="float:left;" >Available topics for review</h4> 
                            <div class="col-md-12">
                                
                                <div id="widget-subscribe-form"  style="margin-bottom: 10px; "  v-for="topic in topics" v-cloak >
                                    
                                    <p>   Posted on @{{topic.created_at}} </p>
                                     <p style="margin-top: -20px "><h4><a :href="'/t/d?url=' + topic.url + '&type=' + categorytype">@{{topic.topic_name}}</a></h4> </p>
                                           
                                </div>
                                   
                            </div> 

                        </div>

                    </div> 

                    <div  v-if="showLoadMore > 0"  class="center"><button class="btn btn-primary" @click="moretopics">Load More</button></div>


    			</section><!-- #content end -->
            </div>

 		</div>

		<!-- Footer
		============================================= -->
		<footer id="footer" class="topmargin noborder" style="background-color: #F5F5F5;">          

            <div class="line nomargin"></div>

            <!-- Copyrights
            ============================================= -->
            <div id="copyrights" class="" style="background-color: #FFF">

                <div class="container clearfix">

                    <div class="col_full center nomargin">
                        <span>Copyrights &copy; 2019 All Rights Reserved by AskPls.</span>
                    </div>

                </div>

            </div><!-- #copyrights end -->

        </footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="../../js/jquery.js"></script>
	<script src="../../js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="../../js/functions.js"></script>

    <script>
	
			new Vue({

				el : '#viewprofile',
				data : {
					id:"", 
					inpId: "{!! $id !!}",
					inpUserCode: "{!! $user_code !!}",
                    categorytype:  "{!! $categorytype !!}",
					url:"", 
					inpUrl: "",  
					inpName: "",
                    inpLocality: "",
					inpCity: "",
					inpCountry: "",
                    inpSpeciality: "",
                    inpType: "",
                    inpQualification: "",
                    inpExp : "",
                    profilepic : "",
					inpTopic: "",
					inpDetail: "", 
					inpCreated_at: "",
					feedback: "",
					feedbacks: [],
					inpKey:"", 
					shownewfeedback: false,
					inpReview : "",
					flg_name : false,
					row_count : 10,
					topics : [],
					topic : "", 
					name: "",
                    showLoadMore : 0,
				},
				mounted:function(){

					axios.get('/p/d/details',{
					params: {

				      	id: this.inpId, 
				      	usercode: this.inpUserCode, 
                        categorytype: this.categorytype,
				      	 
				    	}

					})
					.then(response => {
 
						this.inpName = response.data.name;
                        this.inpSpeciality = response.data.speciality;
                        this.inpType = response.data.type;
                        this.inpGender = response.data.gender;
                        this.inpAddress = response.data.address;
                        this.inpLocality = response.data.locality; 
                        this.inpCity = response.data.city;
                        this.inpCountry = response.data.country;
                        this.inpWebsite = response.data.website;
                        this.inpLinks = response.data.links;
                        this.inpDetails = response.data.details;
                        this.inpQualification = response.data.qualification;
                        this.inpExp = response.data.exp;
                        this.profilepic = response.data.profilepic; 
						

					});

					axios.get('/p/d/showtopics',{
					params: {

				      	id: this.inpId, 
				      	usercode: this.inpUserCode,  
                        categorytype: this.categorytype,
				      	 
				    	}

					})
					.then(response => {

                        if( response.data.length < 10){

                            this.showLoadMore = 0;

                        }else{

                            this.showLoadMore = 1;
                            
                        }

                        this.topics = response.data

                    }); 

				},
				methods: { 
 
                    moretopics:function(){

                        this.row_count = this.row_count + 10;

                        axios.get('/p/getmore' ,{

                                params: {
                                  row_count: this.row_count,
                                  id: this.inpId, 
                                  usercode: this.inpUserCode, 
                                }

                            }).then(response => {

                                if( response.data.length < 10){

                                        this.showLoadMore = 0;

                                    }else{

                                        this.showLoadMore = 1;
                                        
                                }

                                for (var i = 0;  i <= response.data.length - 1; i++ ) {

                                    this.topics.push({

                                            id : response.data[i].id,  
                                            url : response.data[i].url, 
                                            user_id : response.data[i].user_id, 
                                            topic_name : response.data[i].topic_name, 
                                            created_at : response.data[i].created_at, 
                                            
                                            category : response.data[i].category, 
                                            
                                            

                                        });
                                }                       

                        });
                   }
                },

			})

		</script>

</body>
</html>