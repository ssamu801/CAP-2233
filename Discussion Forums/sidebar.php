<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom CSS for navbar */
        .navbar-color {
            background-color: #0b5523; /* Navbar background color */
            overflow: hidden;
        }

        .nav-link {
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            border-radius: 30px;
            
        }

        .dropdown-item {
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            padding-right: 100px;
        }

        /* Active link color */
        .nav-link.active-link{
            color: #0b5523; /* Text color for active links */
            background-color: #ffffff; /* Background color for active links */
            border-radius: 30px;
        }

        @media (min-width: 768px) {

            ul{
                margin-left: -10px;
            }

            .nav li.submenu {
                width:500%;
                border-radius: 30px;
            }

            .nav li:hover {
                background-color: #ffffff; /* Background color for links on hover */
                border-radius: 30px;
                transition: background-color 0.3s, color 0.3s;
                color: #0b5523;
            }

            .nav-link:hover{
                color: #0b5523; /* Text color for links on hover */
                border-radius: 30px;
            }
            .dropdown-item:hover {
                color: #0b5523; /* Text color for links on hover */
                background-color: #ffffff; /* Background color for links on hover */
                transition: background-color 0.3s, color 0.3s;
            }
        }

        /* Hover effect for smaller screens */
        @media (max-width: 767px) {
            .nav-link:hover,
            .dropdown-item:hover {
                color: #0b5523; /* Text color for links on hover */
                background-color: #ffffff; /* Background color for links on hover */
            }
        }

        .bi {
            color: #ffffff; /* Color for icons */
        }
    </style>
</head>
<body>

<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 navbar-color px-0 d-flex sticky-top ">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                <a href="/" class="d-flex align-items-center pb-sm-3 px-sm-2 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5">B<span class="d-none d-sm-inline">rand</span></span>
                </a>
                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                    <li class="dropdown submenu">
                        <a href="#" class="nav-link dropdown-toggle px-sm-3 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fs-5 bi-bootstrap"></i><span class="ms-1 d-none d-sm-inline">Bootstrap</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li>
                </ul>
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Joe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                <div class="col pt-4">
                    <h3>Vertical Sidebar that switches to Horizontal Navbar</h3>
                    <p class="lead">An example multi-level sidebar with collasible menu items. The menu functions like an "accordion" where only a single menu is be open at a time.</p>
                    <hr />
                    <h3>More content...</h3>
                    <p>Sriracha biodiesel taxidermy organic post-ironic, Intelligentsia salvia mustache 90's code editing brunch. Butcher polaroid VHS art party, hashtag Brooklyn deep v PBR narwhal sustainable mixtape swag wolf squid tote bag. Tote bag cronut semiotics, raw denim deep v taxidermy messenger bag. Tofu YOLO Etsy, direct trade ethical Odd Future jean shorts paleo. Forage Shoreditch tousled aesthetic irony, street art organic Bushwick artisan cliche semiotics ugh synth chillwave meditation. Shabby chic lomo plaid vinyl chambray Vice. Vice sustainable cardigan, Williamsburg master cleanse hella DIY 90's blog.</p>
                    <p>Ethical Kickstarter PBR asymmetrical lo-fi. Dreamcatcher street art Carles, stumptown gluten-free Kickstarter artisan Wes Anderson wolf pug. Godard sustainable you probably haven't heard of them, vegan farm-to-table Williamsburg slow-carb readymade disrupt deep v. Meggings seitan Wes Anderson semiotics, cliche American Apparel whatever. Helvetica cray plaid, vegan brunch Banksy leggings +1 direct trade. Wayfarers codeply PBR selfies. Banh mi McSweeney's Shoreditch selfies, forage fingerstache food truck occupy YOLO Pitchfork fixie iPhone fanny pack art party Portland.</p>
                </div>
            </main>
            <footer class="row bg-light py-4 mt-auto">
                <div class="col"> Footer content here... </div>
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to toggle active class on navbar items
    const navbarItems = document.querySelectorAll('.nav-link');
    navbarItems.forEach(item => {
        item.addEventListener('click', () => {
            navbarItems.forEach(item => item.classList.remove('active-link'));
            item.classList.add('active-link');
        });
    });
</script>
</body>
</html>
