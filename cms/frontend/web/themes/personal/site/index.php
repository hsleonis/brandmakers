<?php
    use yii\helpers\Url;
    use yii\helpers\Html;

?>
<div id="main-body">
        <div id="page" class="bottom_slider">
            <ul class="cb-slideshow">
                <li><span>Image 01</span>
                    <div><h4>TROPICAL HOMES LTD</h4><p>Quality is our commitment. Service is our motto. Satisfaction is our goal.</p></div>
                </li>
                <li><span>Image 02</span><div><h4>qui·e·tude</h4><p>dfsfs</p></div></li>
            </ul>
        </div><!--End Of .bottom_slider-->
        


        <div id="main-wrapper">
            <div class="side-nav" data-ng-controller="sideNavController">
                <div class="nav-button">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                </div>
                <!--End Of .nav-button-->
                <div class="textroted">TROPICAL HOMES LTD</div>
                <ul>
                    <li><span><img src="img/search.png" alt=""></span></li>
                    <li><span><img src="img/share.png" alt=""></span></li>
                    <li><span><img src="img/phone.png" alt=""></span></li>
                </ul>
            </div>
            <!--End Of .side-nav-->

            <div id="main-menu" data-ng-controller="mainMenuController" class="box">
                <div class="logo">
                    <p class="home">
                        <a href="#"><img src="img/logo.png" alt=""></a>
                    </p>
                </div>
                <!--End Of .logo-->

                <ul>
                    <li data-ng-repeat="item in main_menu|orderBy:sort_order">
                        <div><a href="{{item.slug}}">{{item.title}}</a></div>
                    </li>
                </ul>

                <span class="trademark">© 2015. TROPICAL HOMES LTD
				<p><a href="http://dcastalia.com/" target="_blank">DEVELOPED BY DCASTALIA</a></p>
			</span>
                <!--End Of .trademark-->
            </div>
            <!--End Of #main-menu-->
			
			<div id="second" class="box">
                <p>ABOUT US</p>
                <div class="about-page-wrapper">
                    <div class="img-box-1"> 
                        <img src="img/strace.jpg" alt=""><br>
                    </div><!--End Of .img-box-1-->

                    <div id="about-page-wrapper-text">
                    To take active role to develop housing sector of the country construct apartments, 
                    commercial space building for middle class and upper middle.
                    </div>


                </div><!--END of .about-page-wrapper-->
                <ul> 
                    <li><a href="#">BACKGROUND</a></li>
                    <li><a href="#">ACHIEVEMENTS</a></li>
                    <li><a href="#">MANAGEMENT TEAM</a></li>
                </ul>

            </div><!--End of #second-->
			
			<div id="detail" class="box">
				<p>
                    <span>BACKGROUND</span>
                    <span class="done"><img src="img/close-symbol.png" alt=""></span>
                </p>

                <div class="detail-wrapper-text"> 
                    <span>
                        Tropical Homes Ltd. goes for a variety of social & other activities, apart from its 
                        mainstream business activity, As a matter of principle, we go for monetary help to the
                        distressed people, provide scholarship for the meritorious & poor students, take part in 
                        various social activities to pursue certain social objectives etc, Tropical Homes Ltd. 
                        takes every care of its employees & their family. Annual gathering of all the families of 
                        the company arranged every year for entertainment, mutual understanding and to break the 
                        monotony of day to-day life. At times, cultural evening is also arranged for enjoyment and 
                        o create a sense of brotherly hood amongst.

                    </span>
                </div>

			</div><!--End of #detail-->
            
			<div id="right-nav" data-ng-controller="rightNavController">
                <ul>
                    <li><img src="img/right-nav-1.png" alt=""></li>
                    <li><img src="img/right-nav-2.png" alt=""></li>
                    <li><img src="img/right-nav-3.png" alt=""></li>
                    <li>&nbsp;</li>
                    <li><img src="img/right-nav-4.png" alt=""></li>
                    <li><img src="img/right-nav-5.png" alt=""></li>
                </ul>
                <p>
                    OUR PROJECTS
                </p>
            </div>
            <!--End Of #right-nav-->

            <div id="right-nav-element" data-ng-controller="rightNavElementController" class="box-alter">
                <ul>
                    <li>PROJECTS</li>
                    <li>ONGOING <span><img src="img/right-nav-1.png"></span></li>
                    <li>UPCOMING<span><img src="img/right-nav-2.png"></span></li>
                    <li>HANDED OVER<span><img src="img/right-nav-3.png"></span></li>
                    <li>COMMERCIAL<span><img src="img/right-nav-4.png"></span></li>
                    <li>RESIDENTILA<span><img src="img/right-nav-5.png"></span></li>
                </ul>
                <p>
                    <a href="#"><img src="img/logo-2.png" alt=""></a>
                </p>
            </div>
            <!--End Of #right-nav-element-->

            <div id="project-details" data-ng-controller="projectDetailsController" class="box-alter">
                Project details here Project details hereProject details hereProject details hereProject details hereProject details hereProject details hereProject details hereProject details hereProject details hereProject details here.
            </div>
            <!--End Of #project-details-->

        </div>
        <!--End Of #main-wrapper-->
    </div>
    <!--END Of #main-body-->