<!DOCTYPE html>
<html>
<body>

<?php

    require_once 'crisisresources.php';

    $emergency_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Lifeline 16-911',
            'classification' => 'Private',
            'services' => 'Lifeline 16-911 plays a crucial role in providing crisis intervention, emotional support, and access to resources for individuals in distress, aiming to prevent suicides and support mental health well-being in the community.',
            'setup' => 'Hybrid',
            'expense' => 'Out of Pocket',
            'number' => ' (+63 2) 8839-2525', 
            'email' => 'customercare@lifeline.com.ph', 
            'location' => 'Valgosons Building, Lifeline Compound, 8484 East Service Road, Km. 18, Sucat, Parañaque City, Philippines 1700',
            'ref' => 'https://www.lifeline.com.ph/'
        ],
        [
            'name' => 'National Emergency Hotline',
            'classification' => 'Government',
            'services' => '911 is the universal emergency crisis line available 24/7.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => ' 911 
            <br> (02) 925-9111 
            <br> (02) 928-7281 [telefax]
            <br> +63966-5000-299 [Globe]
            <br> +63932-318-0440 [Smart]', 
            'email' => '', 
            'location' => '',
            'ref' => 'https://www.gov.ph/'
        ],
        [
            'name' => 'Bureau of Fire Protection',
            'classification' => 'Government',
            'services' => 'The Bureau of Fire Protection (BFP) is committed to prevent and suppress destructive fires, investigate its causes; enforce Fire Code and other related laws; respond to man-made and natural disasters and other emergencies.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => ' (02) 426-0219
            <br> (02) 426-3812
            <br> (02)426-0246', 
            'email' => 'ofc@bfp.gov.ph (Office of the Chief BFP)
            <br> pis@bfp.gov.ph (Public Information Service)', 
            'location' => 'Agham Road, Barangay Bagong Pag-Asa, Quezon City',
            'ref' => 'https://bfp.gov.ph/'
        ],
        [
            'name' => 'Philippine National Police (PNP)',
            'classification' => 'Government',
            'services' => 'The Philippine National Police (PNP) are tasked to enforce the law, prevent and control crimes, maintain peace and order, and ensure public safety and internal security with the active support of the community.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '117
            <br> (02) 8723-0401 
            <br> (02) 8537-4500', 
            'email' => 'ias@pnp.gov.ph', 
            'location' => 'National Headquarters, Camp BGen Rafael T Crame, Quezon City',
            'ref' => 'https://pnp.gov.ph/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Dial-A-Friend',
            'classification' => 'Non-profit Organization',
            'services' => 'Dial-A-Friend program aims to provide a friend to talk to about your problems.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 8525-1743 
            <br> (02) 8525-1881', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Quezon City Helpline 122',
            'classification' => 'Government',
            'services' => 'Helpline 122 services include emergency assistance, COVID-19 related services, social services assistance, reporting of domestic violence, and other concerns that need immediate attention.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '122', 
            'email' => 'helpdesk@quezoncity.gov.ph', 
            'location' => ''
        ],
        [
            'name' => 'Philippine General Hospital PGH Psychiatry and Behavioral Medicine Department',
            'classification' => 'Government',
            'services' => 'The UP-PGH DPBM aims to produce five-star psychiatrists who are competent as clinicians, educators, researchers, social mobilizers and leaders.',
            'setup' => 'Hybrid',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 554-8400 
            <br> (02) 8554-88470 
            <br> (02) 8526-0150 
            <br> (02) 554-8469', 
            'email' => 'pghpsychiatry@gmail.com', 
            'location' => 'PGH Psychiatry and Behavioral Medicine Department 2/F, Ward 7, Taft Avenue, Manila, Metro Manila',
            'ref' => 'https://www.facebook.com/uppgh.dpbm/',
        ],
        [
            'name' => 'Ateneo Bulatao Center For Psychological Services',
            'classification' => 'Private',
            'services' => 'The Ateneo Bulatao Center is the non-profit service and research arm of the Psychology Department of the Ateneo de Manila University. Their practice is in the service of improving the psychological well-being of children, adolescents, and adults across a viarety of settings such as schools, organizations, and corporations.',
            'setup' => 'Hybrid',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 8426-5982', 
            'email' => 'bulataocenter.ls@ateneo.edu', 
            'location' => 'Ateneo de Manila University, Katipunan Avenue, Loyola Heights, 1108 Quezon City, Philippines',
            'ref' => 'https://ateneobulataocenter.com/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
    ];
    
    $alcoholsubtance_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Center for Christian Recovery',
            'classification' => 'Private',
            'services' => 'Center for Christian Recovery (CCR) is a faith-based program that uses a Biblical approach, as well as the 12-Steps, to help individuals break free from denial and develop new, healthy lifestyle patterns.',
            'setup' => 'Face-to-Face',
            'expense' => 'Free',
            'number' => '(02) 345-3228
            <br> 0917 620 1663', 
            'email' => '', 
            'location' => '777 Outlook Drive, Loresville Subd. San Roque Antipolo Philippines',
            'ref' => 'https://centerforchristianrecovery.org'
        ],
        [
            'name' => 'Department of Health (DOH) Substance Abuse Helpline',
            'classification' => 'Government',
            'services' => 'In collaboration with the DOH\'s Dangerous Drugs Abuse Prevention and Treatment Program (DDAPTP), the hotline will provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '1550
            <br> (632) 8651-7800', 
            'email' => 'callcenter@doh.gov.ph', 
            'location' => 'San Lazaro Compound, Tayuman, Sta. Cruz, Manila, Philippines',
            'ref' => 'https://doh.gov.ph/'
        ],
        [
            'name' => 'Department of Health – Treatment and Rehabilitation Center – Cagayan de Oro City',
            'classification' => 'Government',
            'services' => 'The DOH\'s Treatment and Rehabilitation Center aims to provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(02) 8379-55530
            <br> (+63 9) 971-803-569', 
            'email' => 'dohtrccdo@yahoo.com
            <br> himstrccdo@gmail.com', 
            'location' => 'Sayre Highway, Upper Puerto, Cagayan de Oro, Cagayan de Oro Northern, Mindanao, Philippines',
            'ref' => 'https://trccdo.doh.gov.ph/
            <br> https://www.facebook.com/dohtrccagayandeoro'
        ],
        [
            'name' => 'Department of Health – Treatment and Rehabilitation Center – Dulag, Leyte',
            'classification' => 'Government',
            'services' => 'The DOH\'s Treatment and Rehabilitation Center aims to provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(053) 322-2200
            <br> 0917-451-5290
            <br> 0906-086-8020
            <br> 0977-836-8017', 
            'email' => 'salagfacility@gmail.com', 
            'location' => 'Brgy. Highway, Dulag, Leyte, Philippines',
            'ref' => 'https://www.facebook.com/trcdulag/'
        ],
        [
            'name' => 'Department of Health – Treatment and Rehabilitation Center – Malinao',
            'classification' => 'Government',
            'services' => 'The DOH\'s Treatment and Rehabilitation Center aims to provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(052) 830-5390
            <br> (052) 736-0688', 
            'email' => 'doh.mtrc@gmail.com', 
            'location' => 'Comun, Malinao, Albay 4500',
            'ref' => 'https://trcmalinao.com/
            <br> https://www.facebook.com/DOH5.MTRC/'
        ],
        [
            'name' => 'Department of Health – Treatment and Rehabilitation Center – Tagaytay City',
            'classification' => 'Government',
            'services' => 'The DOH\'s Treatment and Rehabilitation Center aims to provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(046) 8483-1334
            <br> 0917-126-4687', 
            'email' => 'tagaytay@ttrc.doh.gov.ph', 
            'location' => 'Conchu Road, Conchu 4109 Trece Martires',
            'ref' => 'https://ddb.gov.ph/
            <br> https://www.facebook.com/DOHTRCTAGAYTAYCITY/'
        ],
        [
            'name' => 'Department of Health – Treatment and Rehabilitation Center – Bicutan',
            'classification' => 'Government',
            'services' => 'The DOH\'s Treatment and Rehabilitation Center aims to provide support and intervention to Persons Who Use Drugs (PWUDs), their families and the public.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '284019463
            <br> 0930-337-6831', 
            'email' => 'dohtrcbicutan@yahoo.com', 
            'location' => '5th St. Camp Bagong Diwa Bicutan, Taguig City 1632 Taguig, Philippines',
            'ref' => 'https://trcbicutan.doh.gov.ph/
            <br> https://www.facebook.com/DOHTRCBICUTAN/'
        ],
    ];

    $anxietydepressionstress_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'In Touch Philippines',
            'classification' => 'Non-profit Organization',
            'services' => 'In Touch: Crisis Line is a free 24/7 emotional and mental support service offered by In Touch Community Services - a non-profit organisation aiming for overall wellbeing.',            
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8893-1893 
            <br> (+63) 917-863-1136 (Globe) 
            <br> (+63) 998-841-0053 (Smart)', 
            'email' => 'intouch@in-touch.org', 
            'location' => 'In Touch Community Services, 48 McKinley Road, Makati City, Metro Manila, Philippines 1219 (at 2nd floor of Holy Trinity Church Offices)',
            'ref' => 'https://in-touch.org/'
        ],
        [
            'name' => 'Hopeline Philippines by Natasha Goulbourn Foundation (NGF)',
            'classification' => 'Non-profit Organization',
            'services' => 'Hopeline Philippines is a free 24/7 suicide prevention and crisis support helpline.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 804-4673 (HOPE) 
            <br> 0917-558-4673 (Globe) 
            <br> 0918-873-4673 (Smart) 
            <br> 2919 (toll-free for GLOBE and TM subscribers)', 
            'email' => 'ngfoundation@gmail.com', 
            'location' => 'Makati, Metro Manila, Philippines',
            'ref' => 'https://ngf-mindstrong.com/'
        ],
    ];

    $covidsupport_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Department of Health (DOH)',
            'classification' => 'Government',
            'services' => 'The Department of Health (DOH) is an executive department of the government of the Philippines responsible for ensuring access to basic public health services by all Filipinos.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '1555
            <br> 02 894-COVID or 02 894-26843', 
            'email' => 'callcenter@doh.gov.ph', 
            'location' => 'San Lazaro Compound, Tayuman, Sta. Cruz, Manila, Philippines',
            'ref' => 'https://doh.gov.ph/'
        ],
        [
            'name' => 'Philippine Mental Health Association COVID-19 Hotline',
            'classification' => 'Non-profit Organization',
            'services' => 'Philippine Mental Health Association COVID-19 Hotline is a phone Mental Health Support for those affected by COVID-19.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '0917-565-2036', 
            'email' => 'hello@pmha.org.ph', 
            'location' => '18 East Ave, Diliman, Quezon City, 1100 Metro Manila',
            'ref' => 'https://pmha.org.ph/'
        ],
        [
            'name' => 'In Touch Philippines',
            'classification' => 'Non-profit Organization',
            'services' => 'In Touch Community Services is a free 24/7 emotional and mental support service offered by In Touch Community Services - a non-profit organisation aiming for overall wellbeing.',            
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8893-1893
            <br> (+63) 917-863-1136 (Globe) 
            <br> (+63) 998-841-0053 (Smart)', 
            'email' => 'intouch@in-touch.org', 
            'location' => 'In Touch Community Services, 48 McKinley Road, Makati City, Metro Manila, Philippines 1219 (at 2nd floor of Holy Trinity Church Offices)',
            'ref' => 'https://in-touch.org/'
        ],
        [
            'name' => 'Philippine Red Cross',
            'classification' => 'Non-profit Organization',
            'services' => 'The Philippines Red Cross (PRC)  mainly focuses on blood services, disaster management, safety services, health services, social services, and youth and volunteer services.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '143
            <br> 1158
            <br> (+63 2) 8790-2300', 
            'email' => 'communication@redcross.org.ph', 
            'location' => '37 EDSA corner Boni Avenue, Barangka-Ilaya, Mandaluyong City 1550',
            'ref' => 'https://redcross.org.ph/'
        ],
        [
            'name' => 'Global TeleHealth, Inc. (KonsultaMD)',
            'classification' => 'Non-profit Organization',
            'services' => 'KonsultaMD is a health app that offers 24/7 online doctor consultations, medicine delivery, diagnostics, and home care.',
            'setup' => 'Online',
            'expense' => 'Out of Pocket',
            'number' => '', 
            'email' => '', 
            'location' => '',
            'ref' => 'https://konsulta.md/'
        ],
        [
            'name' => 'DOH - Research Institute for Tropical Medicine',
            'classification' => 'Non-profit Organization',
            'services' => 'The Research Institute for Tropical Medicine (RITM) is taked by DOH and the government to supervise, plan, and successfully implement research programs to prevent and control prevailing infectious and tropical diseases in the Philippines.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(02) 8807-2631 | 8807-2632 | 8807-2637', 
            'email' => 'do@ritm.gov.ph
            <br> director.ritmdoh@gmail.com', 
            'location' => '9002 Research Drive, Filinvest Corporate City, Alabang Muntinlupa City, Metro Manila Philippines, 1781',
            'ref' => 'https://redcross.org.ph/'
        ],
        [
            'name' => 'Philippine National Police (PNP)',
            'classification' => 'Government',
            'services' => 'The Philippine National Police (PNP) are tasked to enforce the law, prevent and control crimes, maintain peace and order, and ensure public safety and internal security with the active support of the community.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '117
            <br> (02) 8723-0401 
            <br> (02) 8537-4500', 
            'email' => 'ias@pnp.gov.ph', 
            'location' => 'National Headquarters, Camp BGen Rafael T Crame, Quezon City',
            'ref' => 'https://pnp.gov.ph/'
        ],
        [
            'name' => 'Quezon City Helpline 122',
            'classification' => 'Government',
            'services' => 'Helpline 122 services include emergency assistance, COVID-19 related services, social services assistance, reporting of domestic violence, and other concerns that need immediate attention.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '122', 
            'email' => 'helpdesk@quezoncity.gov.ph', 
            'location' => ''
        ],
    ];

    $domesticviolence_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Lunas Collective',
            'classification' => 'Non-profit Organization',
            'services' => 'Lunas Collective is a care space that offers an online chat helpline, which provides survivor-centered feminist care to people experiencing gender-based violence and discrimination. They also support people with concerns about sexual and reproductive health and rights.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '', 
            'email' => 'https://m.me/LunasCollective', 
            'location' => '',
            'ref' => 'https://lunascollective.org/'
        ],
        [
            'name' => 'Philippine National Police (PNP)',
            'classification' => 'Government',
            'services' => 'The Philippine National Police (PNP) are tasked to enforce the law, prevent and control crimes, maintain peace and order, and ensure public safety and internal security with the active support of the community.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '117
            <br> (02) 8723-0401 
            <br> (02) 8537-4500', 
            'email' => 'ias@pnp.gov.ph', 
            'location' => 'National Headquarters, Camp BGen Rafael T Crame, Quezon City',
            'ref' => 'https://pnp.gov.ph/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'classification' => 'Non-profit Organization',
            'services' => 'CPTCSA is a non-profit, non-government child focused institution that offers advocacy programs, prevention actitivites, and treatment services in order to build a safe world for children free from sexual abuse and exploitation.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839
            <br> (+63 2) 8985-0234 
            <br> 0961-718-2655 
            <br> 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Department of Social Welfare and Development (DSWD)',
            'classification' => 'Non-profit Organization',
            'services' => 'The Department of Social Welfare and Development (DSWD) provides immediate rescue and protection; provision of direct financial and material assistance; referrals for medical age, psychological, temporary shelter, and other services.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(632) 8-931-81-01 to 07
            <br> 09178272543 or 09171105686 (Globe)
            <br> 09199116200 (Smart)', 
            'email' => 'inquiry@dswd.gov.ph', 
            'location' => 'DSWD Central Office, Constitution Hills, Batasan Complex, Quezon City, Philippines 1126',
            'ref' => 'https://www.dswd.gov.ph/'
        ],
    ];

    $eatingandbody_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Department of Health (DOH)',
            'classification' => 'Government',
            'services' => 'The Department of Health (DOH) is an executive department of the government of the Philippines responsible for ensuring access to basic public health services by all Filipinos.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '1555
            <br> 02 894-COVID or 02 894-26843', 
            'email' => 'callcenter@doh.gov.ph', 
            'location' => 'San Lazaro Compound, Tayuman, Sta. Cruz, Manila, Philippines',
            'ref' => 'https://doh.gov.ph/'
        ],
        [
            'name' => 'Philippine Mental Health Association',
            'classification' => 'Non-profit Organization',
            'services' => 'Philippine Mental Health Association COVID-19 Hotline is a phone Mental Health Support for those affected by COVID-19.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '0917-565-2036', 
            'email' => 'hello@pmha.org.ph', 
            'location' => '18 East Ave, Diliman, Quezon City, 1100 Metro Manila',
            'ref' => 'https://pmha.org.ph/'
        ],
        [
            'name' => 'Ateneo Bulatao Center For Psychological Services',
            'classification' => 'Private',
            'services' => 'The Ateneo Bulatao Center is the non-profit service and research arm of the Psychology Department of the Ateneo de Manila University. Their practice is in the service of improving the psychological well-being of children, adolescents, and adults across a viarety of settings such as schools, organizations, and corporations.',
            'setup' => 'Online',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 8426-5982', 
            'email' => 'bulataocenter.ls@ateneo.edu', 
            'location' => 'Ateneo de Manila University, Katipunan Avenue, Loyola Heights, 1108 Quezon City, Philippines',
            'ref' => 'https://ateneobulataocenter.com/'
        ],
    ];

    $family_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'classification' => 'Non-profit Organization',
            'services' => 'CPTCSA is a non-profit, non-government child focused institution that offers advocacy programs, prevention actitivites, and treatment services in order to build a safe world for children free from sexual abuse and exploitation.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839
            <br> (+63 2) 8985-0234 
            <br> 0961-718-2655 
            <br> 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Department of Social Welfare and Development (DSWD)',
            'classification' => 'Non-profit Organization',
            'services' => 'The Department of Social Welfare and Development (DSWD) provides immediate rescue and protection; provision of direct financial and material assistance; referrals for medical age, psychological, temporary shelter, and other services.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(632) 8-931-81-01 to 07
            <br> 09178272543 or 09171105686 (Globe)
            <br> 09199116200 (Smart)', 
            'email' => 'inquiry@dswd.gov.ph', 
            'location' => 'DSWD Central Office, Constitution Hills, Batasan Complex, Quezon City, Philippines 1126',
            'ref' => 'https://www.dswd.gov.ph/'
        ],
    ];

    $genderandsexuality_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'classification' => 'Non-profit Organization',
            'services' => 'CPTCSA is a non-profit, non-government child focused institution that offers advocacy programs, prevention actitivites, and treatment services in order to build a safe world for children free from sexual abuse and exploitation.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839
            <br> (+63 2) 8985-0234 
            <br> 0961-718-2655 
            <br> 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Lunas Collective',
            'classification' => 'Non-profit Organization',
            'services' => 'Lunas Collective is a care space that offers an online chat helpline, which provides survivor-centered feminist care to people experiencing gender-based violence and discrimination. They also support people with concerns about sexual and reproductive health and rights.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '', 
            'email' => 'https://m.me/LunasCollective', 
            'location' => '',
            'ref' => 'https://lunascollective.org/'
        ],
        [
            'name' => 'Kapwa MH',
            'classification' => 'Non-government Organization',
            'services' => 'Kapwa is a menu-based Twitter chatbot, the first of its kind for NGOs in the Philippines.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '', 
            'email' => 'https://twitter.com/kapwamh', 
            'location' => '',
            'ref' => 'https://twitter.com/kapwamh',
        ],
        [
            'name' => 'In Touch Philippines',
            'classification' => 'Non-profit Organization',
            'services' => 'In Touch: Crisis Line is a free 24/7 emotional and mental support service offered by In Touch Community Services - a non-profit organisation aiming for overall wellbeing.',            
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8893-1893 
            <br> (+63) 917-863-1136 (Globe) 
            <br> (+63) 998-841-0053 (Smart)', 
            'email' => 'intouch@in-touch.org', 
            'location' => 'In Touch Community Services, 48 McKinley Road, Makati City, Metro Manila, Philippines 1219 (at 2nd floor of Holy Trinity Church Offices)',
            'ref' => 'https://in-touch.org/'
        ],
    ];

    $mentalhealth_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'classification' => 'Non-profit Organization',
            'services' => 'CPTCSA is a non-profit, non-government child focused institution that offers advocacy programs, prevention actitivites, and treatment services in order to build a safe world for children free from sexual abuse and exploitation.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839
            <br> (+63 2) 8985-0234 
            <br> 0961-718-2655 
            <br> 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Lunas Collective',
            'classification' => 'Non-profit Organization',
            'services' => 'Lunas Collective is a care space that offers an online chat helpline, which provides survivor-centered feminist care to people experiencing gender-based violence and discrimination. They also support people with concerns about sexual and reproductive health and rights.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '', 
            'email' => 'https://m.me/LunasCollective', 
            'location' => '',
            'ref' => 'https://lunascollective.org/'
        ],
        [
            'name' => 'Kapwa MH',
            'classification' => 'Non-government Organization',
            'services' => 'Kapwa is a menu-based Twitter chatbot, the first of its kind for NGOs in the Philippines.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '', 
            'email' => 'https://twitter.com/kapwamh', 
            'location' => '',
            'ref' => 'https://twitter.com/kapwamh',
        ],
        [
            'name' => 'In Touch Philippines',
            'classification' => 'Non-profit Organization',
            'services' => 'In Touch: Crisis Line is a free 24/7 emotional and mental support service offered by In Touch Community Services - a non-profit organisation aiming for overall wellbeing.',            
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8893-1893 
            <br> (+63) 917-863-1136 (Globe) 
            <br> (+63) 998-841-0053 (Smart)', 
            'email' => 'intouch@in-touch.org', 
            'location' => 'In Touch Community Services, 48 McKinley Road, Makati City, Metro Manila, Philippines 1219 (at 2nd floor of Holy Trinity Church Offices)',
            'ref' => 'https://in-touch.org/'
        ],
        [
            'name' => 'Hopeline Philippines by Natasha Goulbourn Foundation (NGF)',
            'classification' => 'Non-profit Organization',
            'services' => 'Hopeline Philippines is a free 24/7 suicide prevention and crisis support helpline.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 804-4673 (HOPE) 
            <br> 0917-558-4673 (Globe) 
            <br> 0918-873-4673 (Smart) 
            <br> 2919 (toll-free for GLOBE and TM subscribers)', 
            'email' => 'ngfoundation@gmail.com', 
            'location' => 'Makati, Metro Manila, Philippines',
            'ref' => 'https://ngf-mindstrong.com/'
        ],
        [
            'name' => 'Mindcare Club (MCC)',
            'classification' => 'Private',
            'services' => 'Mindcare Club (MCC) is an NCR-based network of mental health psychiatrists, psychologists, and counselors delivering treatment and therapy through video conference online.',
            'setup' => 'Online',
            'expense' => 'Out of Pocket',
            'number' => '(02) - 8969191 
            <br> 0917-854-9191', 
            'email' => 'mindcareclub.triageofficer@gmail.com', 
            'location' => '',
            'ref' => 'https://www.mindcareclub.com'
        ],
        [
            'name' => 'Project Kamustahan of Provincial Health Office - Biliran',
            'classification' => 'Government',
            'services' => 'Project Kamustahan aims to promote mental health support through information, psycho-education, emotional, psychological, social well-being and community support.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '0927-602-2538', 
            'email' => 'projectkamustahan@gmail.com', 
            'location' => 'BPH, 2nd floor. Provincial Health Office - Biliran 6560 Naval, Philippines',
            'ref' => 'https://www.facebook.com/projectkamustahan'
        ],
        [
            'name' => 'Dial-A-Friend',
            'classification' => 'Non-profit Organization',
            'services' => 'Dial-A-Friend program aims to provide a friend to talk to about your problems.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 8525-1743 | (02) 8525-1881', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Philippine General Hospital PGH Psychiatry and Behavioral Medicine Department',
            'classification' => 'Government',
            'services' => 'The UP-PGH DPBM aims to produce five-star psychiatrists who are competent as clinicians, educators, researchers, social mobilizers and leaders.',
            'setup' => 'Hybrid',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 554-8400 | (02) 8554-88470 | (02) 8526-0150 | (02) 554-8469', 
            'email' => 'pghpsychiatry@gmail.com', 
            'location' => 'PGH Psychiatry and Behavioral Medicine Department 2/F, Ward 7, Taft Avenue, Manila, Metro Manila',
            'ref' => 'https://www.facebook.com/uppgh.dpbm/',
        ],
    ];

    $schoolwork_resources = [
        [
            'name' => 'Ateneo Bulatao Center For Psychological Services',
            'classification' => 'Private',
            'services' => 'The Ateneo Bulatao Center is the non-profit service and research arm of the Psychology Department of the Ateneo de Manila University. Their practice is in the service of improving the psychological well-being of children, adolescents, and adults across a viarety of settings such as schools, organizations, and corporations.',
            'setup' => 'Online',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 8426-5982', 
            'email' => 'bulataocenter.ls@ateneo.edu', 
            'location' => 'Ateneo de Manila University, Katipunan Avenue, Loyola Heights, 1108 Quezon City, Philippines',
            'ref' => 'https://ateneobulataocenter.com/'
        ],
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '  0917-899-8727 
            <br> 0966-351-4518 
            <br> 0908-639-2672 
            <br> 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 
            <br> 0939-936-5433 
            <br> 0966-467-9626', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Bantay Bata Helpline 163',
            'classification' => 'Non-profit Organization',
            'services' => 'Bantay Bata Helpline 163 offers free and confidential support over phone, 7 days a week from 7 AM to 7 PM. They are here for Filipino youth and children, and their families who may require support with abuse & domestic violence, sexual abuse as well as counseling and inquiries for any child-related concerns.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '163', 
            'email' => 'foundation@abs-cbnfoundation.com', 
            'location' => 'Mother Ignacia Avenue, corner Eugenio Lopez St., Diliman, Quezon City, Philippines',
            'ref' => 'https://www.abs-cbnfoundation.com/'
        ],
    ];

    usort($emergency_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($alcoholsubtance_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($anxietydepressionstress_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($covidsupport_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($domesticviolence_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($eatingandbody_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($family_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($genderandsexuality_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($mentalhealth_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    usort($schoolwork_resources, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
?>
</body>
</html>