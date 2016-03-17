<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


    <?php  
        $this->registerCssFile($this->theme->baseUrl."/css/bootstrap.min.css", [
              'media' => 'all',
        ], 'bootstrap');
        
        $this->registerCssFile($this->theme->baseUrl."/css/font-awesome.min.css", [
              'media' => 'all',
        ], 'font-awesome');
        
        $this->registerCssFile($this->theme->baseUrl."/css/linecons.css", [
              'media' => 'all',
        ], 'linecons');
        
        $this->registerCssFile($this->theme->baseUrl."/css/normalize.css", [
              'media' => 'all',
        ], 'normalize');
        
        $this->registerCssFile($this->theme->baseUrl."/css/colors/green.css", [
              'media' => 'all',
        ], 'green');
        
        $this->registerCssFile($this->theme->baseUrl."/css/style.css", [
              'media' => 'all',
        ], 'style');

    ?>

    <?php
        $this->registerJsFile($this->theme->baseUrl."/vendor/js/required.min.all.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/quarca.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 

    ?>


</head>
<body>
    <!-- Page preloader -->
    <div id="page-loader">
        <canvas id="demo-canvas"></canvas>
    </div>
    <!-- container -->
    <div id="hs-container" class="hs-container">
        <div class="switcher" style="left:-40px;">
            <a id="switch-panel" class="hide-panel"><i class="li_params"></i></a>
            <ul class="colors-list">
                <li>
                    <a title="blue" class="blue"></a>
                </li>
                <li>
                    <a title="brown" class="brown"></a>
                </li>
                <li>
                    <a title="cyan" class="cyan"></a>
                </li>
                <li>
                    <a title="gray" class="gray"></a>
                </li>
                <li>
                    <a title="green" class="green"></a>
                </li>
                <li>
                    <a title="light-brown" class="light-brown"></a>
                </li>
                <li>
                    <a title="light-green" class="light-green"></a>
                </li>
                <li>
                    <a title="orange" class="orange"></a>
                </li>
            </ul>
        </div>
        <div class="switcher-responsive" style="right:-40px;">
            <a id="switch-panel-responsive" class="hide-panel"><i class="li_params"></i></a>
            <ul class="colors-list">
                <li>
                    <a title="blue" class="blue"></a>
                </li>
                <li>
                    <a title="brown" class="brown"></a>
                </li>
                <li>
                    <a title="cyan" class="cyan"></a>
                </li>
                <li>
                    <a title="gray" class="gray"></a>
                </li>
                <li>
                    <a title="green" class="green"></a>
                </li>
                <li>
                    <a title="light-brown" class="light-brown"></a>
                </li>
                <li>
                    <a title="light-green" class="light-green"></a>
                </li>
                <li>
                    <a title="orange" class="orange"></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar-->
        <div class="aside1">
            <a class="contact-button"><i class="fa fa-paper-plane"></i></a>
            <a class="download-button"><i class="fa fa-cloud-download"></i></a>
            <div class="aside-content"><span class="part1">SHIMUL DAS</span><span class="part2">Web Developer</span>
            </div>
        </div>
        <aside class="hs-menu" id="hs-menu">
            <!-- <canvas id="demo-canvas"></canvas> -->
            <!-- Profil Image-->
            <div class="hs-headline">
                <a id="my-link" href="#my-panel"><i class="fa fa-bars"></i></a>
                <a href="#" class="download"><i class="fa fa-cloud-download"></i></a>
                <div class="img-wrap">
                    <img src="images/portrait.jpg" alt="" width="150" height="150" />
                </div>
                <div class="profile_info">
                    <h1>Shimul Das</h1>
                    <h4>BSc Computer Science</h4>
                    <h6><span class="fa fa-location-arrow"></span>&nbsp;&nbsp;&nbsp;Dhaka , BD</h6>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="separator-aside"></div>
            <!-- End Profil Image-->
            <!-- menu -->
            <nav>
                <a href="#section1"><span class="menu_name">ABOUT</span><span class="fa fa-home"></span> </a>
                <a href="#section2"><span class="menu_name">RESUME</span><span class="fa fa-newspaper-o"></span> </a>
                <a href="#section3"><span class="menu_name">SKILLS</span><span class="fa fa-diamond"></span> </a>
                <a href="#section4"><span class="menu_name">WORKS</span><span class="fa fa-archive"></span> </a>
                <a href="#section5"><span class="menu_name">CONTACT</span><span class="fa fa-paper-plane"></span> </a>
                <a href="#section6"><span class="menu_name">BLOG</span><span class="fa fa-paper-plane"></span> </a>
            </nav>
            <!-- end menu-->
            <!-- social icons -->
            <div class="aside-footer">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa fa-dribbble"></i></a>
                <a href="#"><i class="fa fa fa-github"></i></a>
            </div>
            <!-- end social icons -->
        </aside>
        <!-- End sidebar -->
        <!-- Go To Top Button -->
        <a href="#hs-menu" class="hs-totop-link"><i class="fa fa-chevron-up"></i></a>
        <!-- End Go To Top Button -->
        <!-- hs-content-scroller -->
        <div class="hs-content-scroller">
            <!-- Header -->
            <div id="header_container">
                <div id="header">
                    <div><a class="home"><i class="fa fa-home"></i></a>
                    </div>
                    <div><a href="#" class="previous-page arrow"><i class="fa fa-angle-left"></i></a>
                    </div>
                    <div><a href="#" class="next-page arrow"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <!-- News scroll -->
                    <div class="news-scroll">
                        <span><i class="fa fa-line-chart"></i>RECENT ACTIVITY : </span>
                        <ul id="marquee" class="marquee">
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.</li>
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.
                            </li>
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.
                            </li>
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.
                            </li>
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.
                            </li>
                            <li>
                                Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.
                            </li>
                        </ul>
                    </div>
                    <!-- End News scroll -->
                </div>
            </div>
            <!-- End Header -->
            <!-- hs-content-wrapper -->
            <div class="hs-content-wrapper">
                <!-- About section -->
                <article class="hs-content about-section" id="section1">
                    <span class="sec-icon fa fa-home"></span>
                    <div class="hs-inner">
                        <span class="before-title">.01</span>
                        <h2>ABOUT</h2>
                        <span class="content-title">PERSONAL DETAILS</span>
                        <div class="aboutInfo-contanier">
                            <div class="about-card">
                                <div class="face2 card-face">
                                    <div id="cd-google-map">
                                        <div id="google-container"></div>
                                        <div id="cd-zoom-in"></div>
                                        <div id="cd-zoom-out"></div>
                                        <address>8690 Paul Street, San fransico</address>
                                        <div class="back-cover" data-card-back="data-card-back"><i class="fa fa-long-arrow-left"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="face1 card-face">
                                    <div class="about-cover card-face">
                                        <a class="map-location" data-card-front="data-card-front"><img src="images/map-icon.png" alt="">
                                        </a>
                                        <div class="about-details">
                                            <div><span class="fa fa-inbox"></span><span class="detail">Yourmail@mail.com</span>
                                            </div>
                                            <div><span class="fa fa-phone"></span><span class="detail">00 123 456 789</span>
                                            </div>
                                        </div>
                                        <div class="cover-content-wrapper">
                                            <span class="about-description">Hello. I am a<span class="rw-words">
                                                <span><strong>Designer</strong></span>
                                            <span><strong>Researcher</strong></span>
                                            <span><strong>Programmer</strong></span>
                                            <span><strong>Dreamer</strong></span>
                                            <span><strong>Leader</strong></span>
                                            </span>
                                            <br>I am passionate about programming and coding
                                            <br>Welcome to my Personal and Academic profile</span>
                                            <span class="status">
                                            <span class="fa fa-circle"></span>
                                            <span class="text">Available as <strong>freelance</strong></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="more-details">
                                <div class="tabbable tabs-vertical tabs-left">
                                    <ul id="myTab" class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#bio" data-toggle="tab">Bio</a>
                                        </li>
                                        <li>
                                            <a href="#hobbies" data-toggle="tab">Hobbies</a>
                                        </li>
                                        <li>
                                            <a href="#facts" data-toggle="tab">Facts</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade in active" id="bio">
                                            <h3>BIO</h3>
                                            <h4>ABOUT ME</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo.Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo.Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo.Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non .</p>
                                        </div>
                                        <div class="tab-pane fade" id="hobbies">
                                            <h3>HOBBIES</h3>
                                            <h4>INTERESTS</h4>
                                            <div class="hobbie-wrapper row">
                                                <div class="hobbie-icon col-md-3"><i class="li_lab"></i>
                                                </div>
                                                <div class="hobbie-description col-md-9">
                                                    <p>Duis eu finibus urna. Pellentesque facilisis tellus vel leo accumsan, a tristique est luctus. Morbi quis euismod nulla. Sed eu nibh eros.</p>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </div>
                                            <div class="hobbie-wrapper row">
                                                <div class="hobbie-icon col-md-3"><i class="li_pen"></i>
                                                </div>
                                                <div class="hobbie-description col-md-9">
                                                    <p>Duis eu finibus urna. Pellentesque facilisis tellus vel leo accumsan, a tristique est luctus. Morbi quis euismod nulla. Sed eu nibh eros.</p>
                                                </div>
                                            </div>
                                            <div class="hobbie-wrapper row">
                                                <div class="hobbie-icon col-md-3"><i class="li_tv"></i>
                                                </div>
                                                <div class="hobbie-description col-md-9">
                                                    <p>Duis eu finibus urna. Pellentesque facilisis tellus vel leo accumsan, a tristique est luctus. Morbi quis euismod nulla. Sed eu nibh eros.</p>
                                                </div>
                                            </div>
                                            <div class="hobbie-wrapper row">
                                                <div class="hobbie-icon col-md-3"><i class="li_shop"></i>
                                                </div>
                                                <div class="hobbie-description col-md-9">
                                                    <p>Duis eu finibus urna. Pellentesque facilisis tellus vel leo accumsan, a tristique est luctus. Morbi quis euismod nulla. Sed eu nibh eros.</p>
                                                </div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                        <div class="tab-pane fade" id="facts">
                                            <h3>FACTS</h3>
                                            <h4>NUMBERS ABOUT ME</h4>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class=" li_cup"></i>
                                                </div>
                                                <div class="facts-number">920</div>
                                                <div class="facts-description">CUPS OF COFFEE</div>
                                            </div>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class="li_bulb"></i>
                                                </div>
                                                <div class="facts-number">65</div>
                                                <div class="facts-description">PROJECTS COMPLETED</div>
                                            </div>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class="li_clock"></i>
                                                </div>
                                                <div class="facts-number">2965</div>
                                                <div class="facts-description">HOURS OF CODING</div>
                                            </div>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class="li_t-shirt"></i>
                                                </div>
                                                <div class="facts-number">35</div>
                                                <div class="facts-description">WORKSHOPS</div>
                                            </div>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class="li_display"></i>
                                                </div>
                                                <div class="facts-number">2M</div>
                                                <div class="facts-description">LINES OF CODE</div>
                                            </div>
                                            <div class="facts-wrapper col-md-6">
                                                <div class="facts-icon"><i class=" li_like"></i>
                                                </div>
                                                <div class="facts-number">100</div>
                                                <div class="facts-description">SATISFIED CUSTOMERS</div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </article>
                <!-- End About Section -->
                <!-- Resume Section -->
                <article class="hs-content resume-section" id="section2">
                    <span class="sec-icon fa fa-newspaper-o"></span>
                    <div class="hs-inner">
                        <span class="before-title">.02</span>
                        <h2>RESUME</h2>
                        <!-- Resume Wrapper -->
                        <div class="resume-wrapper">
                            <ul class="resume">
                                <!-- Resume timeline -->
                                <li class="time-label">
                                    <span class="content-title">EDUCATION</span>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-graduation-cap"></span>
                                        <div class="resume-date">
                                            <span>2008</span>
                                            <div class="separator"></div>
                                            <span>2010</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">COMPUTER ENGINEERING - PHD</h3>
                                        <div class="timeline-body">
                                            <h4>UNIVERSITY OF CALIFORNIA</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-graduation-cap"></span>
                                        <div class="resume-date">
                                            <span>2004</span>
                                            <div class="separator"></div>
                                            <span>2008</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">ELECTRONICS ENGINEERING</h3>
                                        <div class="timeline-body">
                                            <h4>UNIVERSITY OF CALIFORNIA</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="time-label">
                                    <span class="content-title">ACADEMIC AND PROFESSIONAL POSITIONS</span>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-university"></span>
                                        <div class="resume-date">
                                            <span>2009</span>
                                            <div class="separator"></div>
                                            <span>2010</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">GRADUATE STUDENT RESEARCHER</h3>
                                        <div class="timeline-body">
                                            <h4>OXFORD UNIVERSITY COMPUTING LABORATORY</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-university"></span>
                                        <div class="resume-date">
                                            <span>2009</span>
                                            <div class="separator"></div>
                                            <span>2010</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">LAB ASSISTANT</h3>
                                        <div class="timeline-body">
                                            <h4>OXFORD UNIVERSITY COMPUTING LABORATORY</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-university"></span>
                                        <div class="resume-date">
                                            <span>2008</span>
                                            <div class="separator"></div>
                                            <span>2009</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">RESEARCH ASSISTANT</h3>
                                        <div class="timeline-body">
                                            <h4>UNIVERSITY OF NANTES</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="time-label">
                                    <span class="content-title">HONORS AND AWARDS</span>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-star-o"></span>
                                        <div class="resume-date">
                                            <span>2009</span>
                                            <div class="separator"></div>
                                            <span>2010</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">MELLON GRANT</h3>
                                        <div class="timeline-body">
                                            <h4>COMPETITIVE AWARD FOR ACADEMIC EXCELLENCE</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="resume-tag">
                                        <span class="fa fa-star-o"></span>
                                        <div class="resume-date">
                                            <span>2008</span>
                                            <div class="separator"></div>
                                            <span>2009</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <span class="timeline-location"><i class="fa fa-map-marker"></i>San fransico</span>
                                        <h3 class="timeline-header">TRITON AWARD</h3>
                                        <div class="timeline-body">
                                            <h4>COMPETITIVE AWARD FOR ACADEMIC EXCELLENCE</h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem.</span>
                                        </div>
                                    </div>
                                </li>
                                <!-- End Resume timeline -->
                            </ul>
                        </div>
                        <!-- End Resume Wrapper -->
                    </div>
                </article>
                <!-- End Resume Section-->
                
                
                <!-- Skills Section -->
                <article class="hs-content skills-section" id="section3">
                    <span class="sec-icon fa fa-diamond"></span>
                    <div class="hs-inner">
                        <span class="before-title">.06</span>
                        <h2>SKILLS</h2>
                        <span class="content-title">PROGRAMMING SKIILLS</span>
                        <div class="skolls">
                            <span class="skill-description">Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo tortor Vivam.</span>
                            <div class="bar-main-container">
                                <div class="wrap">
                                    <div class="bar-percentage" data-percentage="60"></div>
                                    <span class="skill-detail"><i class="fa fa-bar-chart"></i>LEVEL : INTERMEDIATE</span><span class="skill-detail"><i class="fa fa-binoculars"></i>EXPERIENCE : 3 YEARS</span>
                                    <div class="bar-container">
                                        <div class="bar"></div>
                                    </div>
                                    <span class="label">Php</span><span class="label">Asp</span><span class="label">Wordpress</span>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                        <span class="content-title">DESIGN SKILLS</span>
                        <div class="skolls">
                            <span class="skill-description">Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo tortor Vivam.</span>
                            <div class="bar-main-container">
                                <div class="wrap">
                                    <div class="bar-percentage" data-percentage="80"></div>
                                    <span class="skill-detail"><i class="fa fa-bar-chart"></i>LEVEL : INTERMEDIATE</span><span class="skill-detail"><i class="fa fa-binoculars"></i>EXPERIENCE : 4 YEARS</span>
                                    <div class="bar-container">
                                        <div class="bar"></div>
                                    </div>
                                    <span class="label">Photoshop</span><span class="label">Illustrator</span>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                        <span class="content-title">OFFICE SKILLS</span>
                        <div class="skolls">
                            <span class="skill-description">Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo tortor Vivam.</span>
                            <div class="bar-main-container">
                                <div class="wrap">
                                    <div class="bar-percentage" data-percentage="40"></div>
                                    <span class="skill-detail"><i class="fa fa-bar-chart"></i>LEVEL : ADVANCED</span><span class="skill-detail"><i class="fa fa-binoculars"></i>EXPERIENCE : 5 YEARS</span>
                                    <div class="bar-container">
                                        <div class="bar"></div>
                                    </div>
                                    <span class="label">Ms excel</span><span class="label">Ms word</span><span class="label">Ms powerpoint</span>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                        <span class="content-title">SOCIAL SKILLS</span>
                        <div class="skolls">
                            <span class="skill-description">Lorem ipsum dolor sit amet, consectetur adipiscingVivam sit amet ligula non lectus cursus egestas. Cras erat lorem, fringilla quis sagittis in, sagittis inNam leo tortor Nam leo tortor Vivam.</span>
                            <div class="bar-main-container">
                                <div class="wrap">
                                    <div class="bar-percentage" data-percentage="90"></div>
                                    <span class="skill-detail"><i class="fa fa-bar-chart"></i>LEVEL : EXPERT</span><span class="skill-detail"><i class="fa fa-binoculars"></i>EXPERIENCE : 6 YEARS</span>
                                    <div class="bar-container">
                                        <div class="bar"></div>
                                    </div>
                                    <span class="label">Event production</span><span class="label">Media relation</span>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- End Skills Section -->
                <!-- Works Section -->
                <article class="hs-content works-section" id="section4">
                    <span class="sec-icon fa fa-archive"></span>
                    <div class="hs-inner">
                        <span class="before-title">.07</span>
                        <h2>WORKS</h2>
                        <div class="portfolio">
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/1-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">Logo Design</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href=".work1" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work1">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/2-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">web design</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href="-15.html" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work2">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/3-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">Mobile app</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href="-16.html" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work3">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/4-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">web design</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href="-17.html" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work4">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/5-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">Mobile app</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href="-18.html" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work5">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                            <!-- Portfolio Item -->
                            <figure class="effect-milo">
                                <img src="images/portfolio/6-thumb.jpg" alt="img11" width="282" height="222" />
                                <figcaption>
                                    <span class="label">Logo Design</span>
                                    <div class="portfolio_button">
                                        <h3>Project Title</h3>
                                        <a href="-19.html" class="open_popup" data-effect="mfp-zoom-out">
                                            <i class="hovicon effect-9 sub-b"><i class="fa fa-search"></i></i>
                                        </a>
                                    </div>
                                    <div class="mfp-hide mfp-with-anim work_desc work6">
                                        <div class="col-md-6">
                                            <div class="image_work">
                                                <img src="http://placehold.it/560x420" alt="img" width="560" height="420">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="project_content">
                                                <h2 class="project_title">Project title</h2>
                                                <p class="project_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a auctor sem. Suspendisse egestas nulla eget nunc commodo, et blandit ante tristique. Aliquam dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.
                                                    <br>
                                                    <br>dignissim nulla tellus, sed pellentesque libero pellentesque et. Donec nec sem mattis, suscipit ligula id, porttitor tortor. Maecenas sed egestas odio, vitae euismod nulla. Duis viverra blandit mi quis rhoncus. Aenean vitae turpis et tortor elementum blandit.</p>
                                            </div>
                                        </div>
                                        <a class="ext_link" href="#"><i class="fa fa-external-link"></i></a>
                                        <div style="clear:both"></div>
                                    </div>
                                </figcaption>
                            </figure>
                            <!-- End Portfolio Item -->
                        </div>
                        <!-- End Portfolio Wrapper -->
                    </div>
                </article>
                <!-- End Works Section -->
                <!-- Contact Section -->
                <article class="hs-content contact-section" id="section5">
                    <span class="sec-icon fa fa-paper-plane"></span>
                    <div class="hs-inner">
                        <span class="before-title">.08</span>
                        <h2>CONTACT</h2>
                        <div class="contact_info">
                            <h3>Get in touch</h3>
                            <hr>
                            <h5>We are waiting to assist you</h5>
                            <h6>Simply use the form below to get in touch</h6>
                            <hr>
                        </div>
                        <!-- Contact Form -->
                        <fieldset id="contact_form">
                            <div id="result"></div>
                            <input type="text" name="name" id="name" placeholder="NAME" />
                            <input type="email" name="email" id="email" placeholder="EMAIL" />
                            <textarea name="message" id="message" placeholder="MESSAGE"></textarea>
                            <span class="submit_btn" id="submit_btn">SEND MESSAGE</span>
                        </fieldset>
                        <!-- End Contact Form -->
                    </div>
                </article>
                <!-- End Contact Section -->
            </div>
            <!-- End hs-content-wrapper -->
        </div>
        <!-- End hs-content-scroller -->
    </div>
    <!-- End container -->
    <div id="my-panel">
    </div>
    <!-- PLUGIN SCRIPTS -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&amp;sensor=false"></script>
    <script type="text/javascript" src="js/layout.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <!-- END PLUGIN SCRIPTS -->
</body>
</html>
<?php $this->endPage() ?>
