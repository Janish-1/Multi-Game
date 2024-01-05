@php
$web = DB::table('websettings')->first();
$home = DB::table('homedetails')->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--favicon icon-->
    <link rel="icon" href="https://i.ibb.co/X2V26G9/logo-removebg-preview.png" type="image/png" sizes="16x16">
    <!--title-->
    <title>{{ $web->website_tagline }}</title>
    <!--build:css-->

    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('admin-assets/fonts/line-awesome/line-awesome.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/vendors/js/sweet-alert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/vendors/js/sweet-alert/jquery.sweet-modal.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('front-assets/css/main1.css') }}">
    <!-- endbuild -->
</head>

<body>
    <!--preloader start-->
    <div id="preloader">
        <div class="preloader-wrap">
            <img src="https://i.ibb.co/X2V26G9/logo-removebg-preview.png" alt="logo" width="80"
                class="img-fluid" />
            <div class="thecube">
                <div class="cube c1"></div>
                <div class="cube c2"></div>
                <div class="cube c4"></div>
                <div class="cube c3"></div>
            </div>
        </div>
    </div>
    <!--preloader end-->
    <!--header section start-->
    <header class="header">
        <!--start navbar-->
        <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="height:45px;">
                    <img src="https://i.ibb.co/X2V26G9/logo-removebg-preview.png" alt="logo" width="80"
                        class="img-fluid" style="margin-top:-17px;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="ti-menu"></span>
                </button>

                <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto menu">
                        <li><a href="{{ url('/') }}" class=""> Home</a></li>
                        <li><a href="#about" class="page-scroll">About</a></li>
                        <li><a href="#features" class="page-scroll">Features</a></li>
                        <li><a href="#screenshots" class="page-scroll">Screenshots</a></li>
                        <li><a href="#faq" class="page-scroll">Faq</a></li>
                        <li><a href="#process" class="page-scroll">Review</a></li>
                        <li><a href="#contact" class="page-scroll">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--header section end-->

    <div class="main">
        <!--page header section start-->
        <section class="page-header-section ptb-100 bg-image this_is_cusrtom" image-overlay="8">
            <div class="background-image-wraper" style="background: url('assets/img/slider-bg-1.jpg'); opacity: 1;">
            </div>
            <div class="container">
                        <br><br>
                <div class="row align-items-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="page-header-content text-white pt-4">
                            <h1 class="text-white mb-0 font-weight-bold">{{ $web->privacy_title }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--page header section end-->

        <!--breadcrumb section start-->
        <div class="breadcrumb-bar gray-light-bg border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-breadcrumb">
                            <ol class="breadcrumb pl-0 mb-0 bg-transparent">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Privacy Policy</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--breadcrumb section end-->

        <!--blog section start-->
        <div class="module pt-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <center>
                            <!-- Post-->
                            <article class="post">
                                <div class="post-wrapper">
                                    <div class="post-header">
                                        <h2 class="post-title">{{ $web->privacy_title }}</h2>
                                    </div>
                                    <div class="post-content">
                                        <p>We, at Firehawks 24x7 games Pvt Ltd (“Boomlly”, We, us, our) respect the privacy of our users (Users, you, your) and we want you to be informed of our practices, when we collect, process, use and disclose information. This Privacy Policy (Policy) governs our data collection, processing, transfer protocols, to enable you to better understand the manner in which we handle your personal information (as defined by law). This Privacy Policy covers only information collected through our Platform and does not cover any other data collection or processing, without limitation, collection conducted offline, or through our products or services that do not link directly with this Policy, or by third-party sites that we may link to.</p>

<p>By accessing, downloading, and/or using the Platform, you agree to be governed by the terms of this Policy. This Policy shall be read in conjunction with the <a href="https://boomlly.com/">Terms of Use available at https://boomlly.com/</a>, which shall form a binding agreement with you.</p>

<p>We may revise this Policy, and update our Services and the Platform from time to time. So, we request you to please review this page regularly and take notice of any changes we make. We will, in any event, periodically inform our users of this Policy, and any change in this Policy, as required by law. If you do not agree with any part of this Policy, please stop using our Services or accessing this Platform immediately.</p>

<p>Capitalized words used in this Policy and not defined will have the meaning given to such words in the Terms of Use.</p>

<p><strong>1. What Data Do We Collect ?</strong></p>

<p>When you visit our website, use our mobile application, and our Services, you trust us with your personal information. We take your privacy seriously. Through this policy, we have tried to explain to you in the clearest and simplest way possible what information we collect, why we collect it, by what means, and how we use it. We collect this information to ensure that we can provide you our Services in the best manner possible. And we wish to keep such collection and usage of data as transparent as possible.</p>

<p><strong>1.1. Data you submit when signing up for and using our Services:</strong></p>

<p>1. Mobile Number: We mandatorily ask you for your mobile number to be able to verify you, the user, through a One Time Password.</p>

<p>2. State: We ask you to mandatorily confirm the State you are accessing the Platform from, as part of our effort to block users from States where the playing of games involving real money, may be restricted or prohibited.</p>

<p>3. Language Preference: We ask you to mandatorily confirm your preferred language, so that we are able to determine what language our Platform should be accessible in.</p>

<p>4. KYC Information: We may ask you to mandatorily submit KYC documents to our licensed service providers, for compliance with applicable laws.</p>

<p>5. Phonebook: We allow you, at your own option, to allow us access to your contacts, phone call logs, and permission to manage phone calls, for the purpose of fraud prevention, to enable a seamless sign-up on our Platform by user verification through a missed call, and for our referral features.</p>

<p>6. User Profile Data: We allow you, at your option, to provide us your name, e-mail address, gender, date of birth, city, and your display picture, to maintain your user profile on the Platform, and offer customized services.</p>

<p>7. Feedback Data: We allow you, at your option, to provide us information for the purposes of feedback</p>

<p><strong>1.2. Data we collect from usage of the Services:</strong></p>

<p>Geolocation Data: We allow you, at your option, to submit location data from your mobile device. You may, at your option, allow us to collect this data when our Platform is operating in the background of our mobile device. We collect such information as part of our effort to block users from States where the playing of games involving real money, may be restricted or prohibited.</p>

<p>Transaction Information: If you transact on our Platform, i.e., if you add or withdraw money from the Platform to engage in paid gameplay, we collect transaction information, such as the amount added, withdrawn, or otherwise used to make a purchase; the mode of payment; the date and time of payment; purchase history and corresponding invoice (where required).</p>

<p>Device Data: We collect data about the devices used to access our Services, including the hardware model, device IP address, installed software, available device storage, unique device identifiers, advertising identifiers, and mobile network data, to help identify users and prevent fraud.</p>

<p>Usage Data: We collect data about how you interact with our Services. This includes data such as access date and times, Platform features or pages viewed, Platform crashes and other system activity, type of browser, or third-party sites or services used to interact with our Services, so that we are able to improve users’ experience on the Platform.</p>

<p>Cookies: We collect information through the use of “cookies”, to recognize you and your device, better understand how you navigate through our Services, and improve user experience. You can disable cookies through your web or mobile device through browser settings.</p>

<p><strong>1.3. Data we receive from other sources:</strong></p>

<p>We may receive information about you from third-party websites, if you use social media plug-ins to connect with us. You will be bound by the terms of use, privacy policies of these third parties, and we urge you to review and familiarize yourself with the policies of these websites, before continuously interacting with them.</p>

<p><strong>2. How And Why Do We Use Collected Data?</strong></p>

<p>We, and/or third parties who act on our behalf, or provide services to us, may use your data to ensure that our Services are as up to date as possible, and offered in the most optimal manner to you</p>

<p><strong>2.1. Enable Services:</strong></p>

<p>We use the data collected to maintain, improve, and personalize our Services. This includes using the data to:</p>

<ul>
    <li>create your profile with us;</li>
    <li>improve the Services, design and navigation of the Platform;</li>
    <li>facilitate in-app purchases;</li>
    <li>provide requested information and support needed to effect transactions on or through our Platform;</li>
    <li>determine your eligibility to avail our Services, and participation in exclusive contests, programs and related offerings; and</li>
    <li>perform internal operations that are necessary to provide our Services, such as troubleshooting software bugs, conducting data analysis, detecting fraud, or analyzing usage and activity trends on our Platform.</li>
</ul>

<p><strong>2.2. Customer Support:</strong></p>

<p>We use the data collected to provide customer support and/or resolve your concerns arising from the use of our Services</p>

<p><strong>2.3. Research and Development:</strong></p>

<p>We use the data collected for research, analysis, and the development of our Platform to improve the UI/UX, to allow you optimum use of the Platform</p>

<p><strong>2.4. Marketing and Outreach:</strong></p>

<p>We may use the data collected to promote and market the Platform and our Services.</p>

<p><strong>2.5. Legal Compliance:</strong></p>

<p>We may use the data collected to perform our legal or contractual obligations, as otherwise permitted by law, or as and when requested by legal, regulatory, or investigatory authorities.</p>

<p><strong>3. When And With Whom Do We Share Collected Data?</strong></p>

<p>We will share your data with third parties only in accordance with this Policy, so that we are able to provide the Services and enable an improved user experience. We have and will never sell your data to third parties for profit.</p>

<p><strong>3.1. Third Parties:</strong></p>

<p>Service Providers: We work with third-party service providers to perform services on our behalf, such as providing us infrastructural, transactional, maintenance, support, analytics, and marketing and allied services. We only share such data with them, as is necessary for us to provide the Services to you. For matters related to KYC processing, we retain no part or record of your KYC documents, except for an encrypted hash value (i.e., algorithmic code) which has none of your personal information.</p>

<p>Third Party Services: Through the Platform, you may, at your option, be able to connect with other websites, products, or services that we do not control. The use and access of such websites, products or services is subject to their respective privacy policies, and outside our control. We urge you to review and familiarize yourself with their policies before using or accessing them.</p>

<p>Subsidiaries and Affiliates: We may share collected data with subsidiaries, affiliates, or related entities to fulfil a contractual obligation to you.</p>

<p>Change in Control: If we (or our affiliates) are involved in a merger, acquisition and sale of all or substantially all of its assets or equity, we may have to disclose databases stored in the course of our operations.</p>

<p><strong>3.2. Legal Enforcement Authorities:</strong></p>

<p>We may share the data collected as required by applicable law, so as to co-operate with law enforcement agencies or upon receipt of a court order, and/or with courts and public authorities to protect you, us, or third parties from harm, including fraud or instances where somebody’s physical safety may be at risk.</p>
<p><strong>4. What Are Your Rights Regarding Collected Data?</strong></p>

<p>We consider it important to empower you with rights regarding your data. And we give you the following rights in this regard</p>

<p><strong>4.1. Access:</strong></p>

<p>You may access your information by accessing your account or profile on our Platform.</p>

<p><strong>4.2. Rectification:</strong></p>

<p>You may also request corrections, updates, or deletion of your information. We will make reasonable efforts to respond promptly to such requests in accordance with applicable laws. You can reach out to us at the address given in the ‘How Can You Contact Us’ section below</p>

<p><strong>4.3. Withdrawal of Consent:</strong></p>

<p>You may withdraw your consent given to us for processing your data. If you do so, we may be unable to provide the Services for which such data was sought. To withdraw your consent, you may please write us an email at the address given in the ‘How Can You Contact Us’ section below.</p>

<p><strong>4.4. Deletion of Account:</strong></p>

<p>If you wish to delete your account maintained with us, you must write to us at the address given in the ‘How Grievance Redressal Works’ section below. Upon approval of such a request, your account will initially stand deactivated for a period of 90 days, within which you may re-activate your account, by accessing your account with your registered details. Alternatively, your account will be deleted and you may not be able to retrieve such information which is purged from our systems.</p>

<p>[Please note that not with standing the above rights, we may retain your data for as long as is necessary for the performance of the contract between you and us and to comply with our legal obligations. We will not retain your data if it is no longer required by us and there is no legal requirement to retain the sa</p>

<p><strong>5. Term?</strong></p>

<p>Notwithstanding the rights herein, we may retain your data for as long as is necessary for the performance of the contract between you and us and to comply with our legal obligations. We will not retain your data if it is no longer required by us and there is no legal requirement to retain the sa</p>

<p><strong>6. How Grievance Redressal Works?</strong></p>

<p>If you have any questions or want to seek clarifications about this Policy, or any complaints, comments, concerns, or feedback about our Data privacy and protection practices, you may contact the Grievance Officer at:</p>

<p>Grievance Officer,</p>

<p>Firehawks 24x7 games Pvt Ltd</p>

<p>Mobile: xxxxxxxxx</p>

<p>E-mail: boomlly24x7@gmail.com</p>

<p>Office Hours: 10 am to 5 pm</p>

<p>If any court or other competent authority finds any of this Privacy Policy to be invalid or unenforceable, the other terms of this Privacy Policy will not be affected. This Privacy Policy is governed by and interpreted in accordance with the laws of the Republic of India. Any dispute arising in connection with this Privacy Policy will be subject to the exclusive jurisdiction of the courts located in the city of Jaipur, Rajasthan, India</p>

<p><strong>7. What Are Our Data Security and Protection Practices?</strong></p>

<p>We maintain appropriate technical and physical safeguards to protect Information against accidental or unlawful destruction or loss, alteration, unauthorized disclosure or access, and any other unlawful form of processing of the data in our possession. These safeguards ensure a level of protection commensurate to the risk, the nature of our business, and take into account available technologies, implementation costs, the nature, context and purpose of processing, and the degree or likelihood of risk.</p>

<p>However, Boomlly does not guarantee that Information will not be accessed, disclosed, altered or destroyed by breach of any of the above-mentioned safeguards. Boomlly takes all steps reasonably necessary to ensure that Information is treated securely and in accordance with this Policy.</p>

<p>Boomlly does not warrant that the Platform, its servers, or any communications shared by us or on our behalf are completely impenetrable from a security standpoint or are virus free. Boomlly will not be liable for any damages of any kind arising from the use of the Platform, including, but not limited to any indirect, incidental, special, consequential or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly or any loss of data, use, good-will, or other intangible losse</p>

<p><strong>8. Do We Transfer Data Across Borders?</strong></p>

<p>We do not store or transfer your data outside India.</p>

<p>We may revise our position, and may transfer your data outside India to territories in which our affiliates or subsidiaries are incorporated in, or work out of; and we will do so upon due notification to you. We will do so only if the destination jurisdiction has an adequate and appropriate level of protection and where the transfer is lawful and necessary for performance of our obligations to you. We will comply with our legal and regulatory obligations in relation to your data, including having a lawful basis for transferring it, and putting appropriate safeguards in place to ensure an adequate level of protection for your data.</p>
<p><strong>9. Do We Collect Data From Children?</strong></p>

<p>Our Services are not directed to persons under the legal age of eighteen years. Boomlly does not knowingly collect any information from children under legal age. If we are informed that a child under legal age has provided us with their personal information, we will take all the necessary steps to remove such information from our servers and terminate such an account. If you become aware that any child has provided personal information, please inform us by writing to us at the address given in the ‘How Can You Contact Us’ section below</p>

<p><strong>10. What If There Are Changes To This Policy?</strong></p>

<p>Boomlly may periodically review and change this Policy to incorporate such changes as may be considered appropriate and will strive to update you of such changes with prior notice, where possible. We urge you to review the Policy on a periodic basis; in the event we make any significant changes to this Policy we will inform you in advance. Your continued use of the Platform and our Services will deem you as having consented to the prevailing Policy.</p>

<p><strong>11. Restriction Of Liability</strong></p>

<p>Boomlly makes no claims, promises or guarantees about the accuracy, completeness, or adequacy of the contents available through the App and expressly disclaims liability for errors and omissions in the contents available through the App.</p>

<p>No warranty of any kind, implied, expressed or statutory, including but not limited to the warranties of non-infringement of third party rights, title, merchantability, fitness for a particular purpose and freedom from computer virus, is given with respect to the contents available through the App or its links to other internet resources as may be available to Your through the App.</p>

<p><strong>Refund & Cancellation Policy</strong></p>

<p><strong>Refund Policy -</strong> All refunds will be credited to your Account. The Company may withdraw and / or cancel any contest(s) to be conducted or already conducted, without prior notice to any Users or winners of any Games / contest(s). If paid by credit card, refunds will be issued to the original credit card provided at the time of purchase and in case of payment gateway name payments refund will be made to the same account.</p>

<p><strong>Cancellation Policy -</strong> A transaction, once confirmed, is final and no cancellation is permissible. Boomlly may, in certain exceptional circumstances and at its sole and absolute discretion, refund the amount to the User after deducting applicable cancellation charges and taxes. For other queries please contact us at boomlly24x7@gmail.com</p>

                                    </div>
                                </div>
                            </article>
                            <!-- Post end-->
                        </center>


                        <!-- Page Navigation end-->
                    </div>
                </div>
            </div>
        </div>
        <!--blog section end-->



    </div>

    <!--footer section start-->
    <!--when you want to remove subscribe newsletter container then you should remove .footer-with-newsletter class-->
    <footer class="footer-1 gradient-bg ptb-60 footer-with-newsletter">
        <div class="container bottom_border">
            <div class="row">
                <div class=" col-sm-4 col-md col-sm-4  col-12 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">About us</h5>
                    <!--headin5_amrc-->
                    <p class="mb10">
                        {{ \Illuminate\Support\Str::limit($home->about_desc, 250, $end = '...') }}</p>
                </div>


                <div class=" col-sm-4 col-md  col-6 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                    <!--headin5_amrc-->
                    <ul class="footer_ul_amrc">
                        <li><a href="{{ url('/') }}" class=""> Home</a></li>
                        <li><a href="#features" class="page-scroll">Features</a></li>
                        <li><a href="#screenshots" class="page-scroll">Screenshots</a></li>
                        <li><a href="#faq" class="page-scroll">Faq</a></li>
                        <li><a href="#process" class="page-scroll">Review</a></li>
                    </ul>
                    <!--footer_ul_amrc ends here-->
                </div>


                <div class=" col-sm-4 col-md  col-6 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                    <!--headin5_amrc-->
                    <ul class="footer_ul_amrc">
                        <li><a href="{{ url('/') }}/about-us">About Us</a></li>
                        <li><a href="{{ url('/') }}/privacy-policy">Privacy Policy</a></li>
                        <li><a href="{{ url('/') }}/terms-condition">Terms & Conditions</a></li>
                        <li><a href="{{ url('/') }}/refund-policy">Refund Policy</a></li>
                        <li><a href="{{ url('/') }}/contact-us">Contact</a></li>
                    </ul>
                    <!--footer_ul_amrc ends here-->
                </div>


                <div class=" col-sm-4 col-md  col-12 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">Contact us</h5>
                    <!--headin5_amrc ends here-->

                    <ul class="footer_ul2_amrc">
                        <p><i class="las la-map-marked-alt icon-size-sm"></i> {{ $web->address }} </p>
                        <p><i class="las la-phone-volume icon-size-sm"></i> {{ $web->pnum }} </p>
                        <p><i class="las la-envelope icon-size-sm"></i> {{ $web->pemail }} </p>
                    </ul>
                    <!--footer_ul2_amrc ends here-->
                </div>
            </div>
        </div>


        <div class="container">
            <center>
                <div class="list-inline social-list-default background-color social-hover-2 mt-2">
                    <li class="list-inline-item"><a class="dribbble" href="https://www.instagram.com/boomlly.com_?igshid=OGQ5ZDc2ODk2ZA=="
                            target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a class="dribbble" href="https://whatsapp.com/channel/0029Va4ydTgAojYnH5E1VQ3U"
                            target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                </div>
                <!--foote_bottom_ul_amrc ends here-->
                <p class="text-center">{{ $web->copyright }}</p>
            </center>
            <!--social_footer_ul ends here-->
        </div>
        <!--end of container-->
        <!--end of container-->
    </footer>
    <!--footer section end-->
    <!--scroll bottom to top button start-->
    <div class="scroll-top scroll-to-target primary-bg text-white" data-target="html">
        <span class="fas fa-hand-point-up"></span>
    </div>
    <!--scroll bottom to top button end-->
    <!--build:js-->
    <script src="{{ URL::asset('front-assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/popper.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/jquery.easing.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/s/vendors/countdown.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/jquery.rcounterup.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/vendors/validator.min.js') }}"></script>
    <script src="{{ URL::asset('admin-assets/vendors/js/sweet-alert/sweet-alert.js') }}"></script>
    <script src="{{ URL::asset('admin-assets/vendors/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin-assets/css/custom/js/screenshot/screenshot.js') }}"></script>
    <script src="{{ URL::asset('front-assets/js/app.js') }}"></script>
    <!--endbuild-->
</body>

</html>
