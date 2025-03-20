<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile_data = [
          "name" => "Rashid Mehmood",
          "image" => "/images/profile.jpg",
          "objective" => "To secure a challenging and dynamic position that aligns with my qualifications, \
                      experience, and capabilities, while fostering continuous professional growth. I aim to \
                      stay at the forefront of emerging technologies and industry trends, adapting \
                      proactively to innovations. With dedication and hard work, I strive to expand my \
                      expertise and contribute meaningfully to organizational success.",
          "contact" => [
            [ "label" => "Mobile", "value" => "+92 336 0563639" ],
            [ "label" => "Landline", "value" => "+92 051 5490745" ],
            [ "label" => "Email", "value" => "laravelprodev@gmail.com" ],
            [ "label" => "LinkedIn", "value" => "https://www.linkedin.com/in/rashi8138" ],
            [ "label" => "Skype", "value" => "rashi8138" ]
          ],
          "academics" => [
            [ "degree" => "BSIT", "year" => "2016", "institute" => "University of Engineering & Technology, Taxila", "gpa" => "2.8/4.0" ],
            [ "degree" => "HSSC", "year" => "2012", "institute" => "Army Public College, Rawalpindi", "gpa" => "70%" ],
            [ "degree" => "SSC", "year" => "2010", "institute" => "EFA High School, Rawalpindi", "gpa" => "75%" ]
          ],
          "honors" => [
            [ "year" => "2012", "details" => "Successfully cleared the written, physical, psychological, and medical \
                                      tests for Pakistan Army and AirForce Officers Recruitment (also known as the \
                                      Commissioned Officers' Test). However, I opted to pursue higher education \
                                      rather than proceed with the final selection process." ],
            [ "year" => "2015", "details" => "Won the intra-university General Knowledge competition at Federal Urdu University." ],
            [ "year" => "2016", "details" => "Represented my university in web development competitions at IQRA University, Islamabad." ],
            [ "year" => "2017", "details" => "My final year project was selected for presentation at the annual exhibition hosted by FAST University in Islamabad." ],
            [ "year" => "2020", "details" => "I successfully cleared the written test for the Pakistan Army Short Service \
                                      Commission, which primarily assessed general knowledge, physics, mathematics, and English." ],
          ],
          "skills" => [
            [ "category" => "Programming Languages", "details" => "C, C++, C#, Java, JavaScript, PHP, Python" ],
            [ "category" => "Databases", "details" => "Oracle, MySQL, SQLite, MongoDB, VectorDB, PostgreSQL" ],
            [ "category" => "Operating Systems", "details" => "Windows 98|XP|7|8|10, Windows Server 2003, CentOS, Kali Linux, MacOS, Ubuntu" ],
            [ "category" => "Softwares and Tools", "details" => "IDEs & Shells Visual Studio, Netbeans, Eclipse, Sublime Text, PhpStorm, PyCharm, GitHub \
                                                          Designing & CASE tools Software Ideas Modular, Rational Rose, Adobe Photoshop, Corel Draw, Trello, ClickUp \
                                                          CMS WordPress, Drupal, Joomla" ],
            [ "category" => "AI and ML", "details" => "Feedforward Neural Networks and Convolutional Neural Networks using numpy, pytorch, tensor-flow" ],
            [ "category" => "Web Development", "details" => "Php Laravel Framework (PSR-12 coding style, Composer, \
                                                      Blade Template, Form Façade, Passport, Echo, Pusher, \
                                                      Voyager, Elixir, Mix, Artisan, Tinker, Eloquent), \
                                                      Python Django Framework \
                                                      JavaScript (jQuery, Ajax, Vue, Angular-1, Node, npm, Gulp, \
                                                      Grunt, HighChart, noUiSlider, axious, JSON, Google Map API), \
                                                      CSS (Bootstrap, MDBootstrap, W3.css, Materizecss, Media \
                                                      Queries, LESS, SASS), \
                                                      HTML-5 (Semantic Elements, Canvas, Local Storage, \
                                                      Geolocation API, Required Attribute, Responsive Design, \
                                                      Drag and Drop API, WebSockets)" ],
          ],
          "experience" => [
            [ "position" => "Backend Web Developer", "company" => "Freelancing", "duration" => "2015 - 2016", "details" => "Did web development based freelancing at various platforms \
                                                                                                      like freelancer.com, upwork and fiverr" ],
            [ "position" => "Full-Stack Developer", "company" => "VirEmp (viremp.com)", "duration" => "Jan 2017 - July 2018", "details" => "Worked as a Full-Stack PHP/Laravel Developer, focusing primarily on hybrid \
                                                                                                      Point-of-Sale (POS) systems. \
                                                                                                      Designed and developed complete ERP solutions for small-scale local \
                                                                                                      businesses, tailoring systems to meet their unique operational needs." ],
            [ "position" => "Full-Stack Developer", "company" => "TechInsects (techinsects.com)", "duration" => "Dec 2017 - Dec 2020", "details" => "Initially started as a part-time Backend Developer but transitioned \
                                                                                          to a full-time Full-Stack PHP/Laravel Developer after a few months. Gained hands-on experience \
                                                                                          with international projects, including eptitude.co.in and gigclassifieds.com, which \
                                                                                          broadened my expertise in both frontend and backend technologies. \
                                                                                          Acquired proficiency in modern tools like Vue.js, WebRTC, and networking \
                                                                                          technologies such as sockets for real-time chat and audio/video communication. \
                                                                                          Took on leadership roles, managing development operations, leading teams, \
                                                                                          and engaging in direct client communication." ],
            [ "position" => "Software Architect", "company" => "Asset Management Company", "duration" => "2021 - 2023", "details" => "Signed a three-year contract with a blockchain-based asset management \
                                                                                                  company under Bigwave Ltd (bigwavesoftware.com) as a Software Architect. \
                                                                                                  • Spearheaded the development of their flagship product (crypto4winners.com) \
                                                                                                  from scratch, playing a pivotal role in its success. \
                                                                                                  • Gained extensive experience in blockchain technology and contributed to a \
                                                                                                  product that achieved an estimated valuation of over $150 million USD by the \
                                                                                                  time of my departure in December 2023." ],
          ],
          "hobbies" => [
            [ "title" => "Gaming", "description" => "Since childhood, I have been passionate about video games, playing titles such as \
                                              Tekken, Metal Slug, and GTA. However, the game I enjoyed the most was Call of Duty: \
                                              Modern Warfare. In multiplayer mode, I played with friends on online servers and \
                                              nearly mastered every weapon available in the game." ],
            [ "title" => "Movies & Netflix", "description" => "I have a strong interest in science fiction movies, and my favorite genre is time travel. \
                                                        Before the advent of YouTube and Netflix, I loved watching shows on National \
                                                        Geographic and Discovery Channel." ],
            [ "title" => "Cricket", "description" => "Cricket is considered the national game here in Pakistan, and it is the only physical \
                                              activity in which I was so deeply involved that I became confident in my ability to play \
                                              professionally. I was an all-rounder and served as the captain of my colony cricket \
                                              team. In school and college, I frequently skipped classes with my cricket-enthusiast \
                                              friends just to play the game." ],
            [ "title" => "Building and Construction", "description" => "Construction is our family business, and I have been involved in the overall planning, \
                                                                design, and development of numerous small-scale projects. I have personally designed \
                                                                and executed three projects ranging from 1,500 to 5,000 square feet. I take pride in \
                                                                hands-on work, having installed tiles, marble, wallpaper, and wall paneling in several of \
                                                                these projects." ],
            [ "title" => "Electrical and Plumbing Work", "description" => "Due to my involvement in the construction business, I have gained hands-on \
                                                                    experience in installing plumbing and electrical systems for complete houses. I have \
                                                                    also personally installed a 6kW hybrid solar system at my home." ],
          ]
        ];

        return Inertia::render('Portfolio', ['profile' => $profile_data]);
    }
}
