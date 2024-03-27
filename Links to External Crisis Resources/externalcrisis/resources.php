<!DOCTYPE html>
<html>
<body>

<?php
    $dir_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'category' => 'Hospital, Hotline',
            'classification' => 'Government',
            'services' => 'The NCMH is a special training and research hospital mandated to render a comprehensive (preventive, promotive, curative and rehabilitative) range of quality mental health services nationwide. It also gives and creates venues for quality mental health education, training and research geared towards hospital and community mental health services nationwide.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => ' 0917-899-8727 | 0966-351-4518 | 0908-639-2672 | 1553 (Toll-free Luzon-wide Landline)',
            'email' => 'mcc@ncmh.gov.ph', 
            'location' => 'Nueve de Febrero, Mandaluyong, Kalakhang Maynila, Philippines',
            'ref' => 'https://ncmh.gov.ph/'
        ],
        [
            'name' => 'Lifeline 16-911',
            'category' => 'Facility/Clinic, Hotline', 
            'classification' => 'Private',
            'services' => 'Lifeline 16-911 plays a crucial role in providing crisis intervention, emotional support, and access to resources for individuals in distress, aiming to prevent suicides and support mental health well-being in the community.',
            'setup' => 'Online',
            'expense' => 'Out of Pocket',
            'number' => '(+63 2) 8839-2525', 
            'email' => 'customercare@lifeline.com.ph', 
            'location' => 'Valgosons Building, Lifeline Compound, 8484 East Service Road, Km. 18, Sucat, Parañaque City, Philippines 1700',
            'ref' => 'https://www.lifeline.com.ph/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'category' => 'Advocacy Group, Hotline, Support Group', 
            'classification' => 'Non-profit Organization',
            'services' => 'CPTCSA is a non-profit, non-government child focused institution that offers advocacy programs, prevention actitivites, and treatment services in order to build a safe world for children free from sexual abuse and exploitation..',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839 | (+63 2) 8985-0234 | 0961-718-2655 | 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Philippine Red Cross',
            'category' => 'Advocacy Group, Facility/Clinic, Hotline, Support Group', 
            'classification' => 'Non-profit Organization',
            'services' => 'The Philippines Red Cross (PRC)  mainly focuses on blood services, disaster management, safety services, health services, social services, and youth and volunteer services.',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '143 | (+63 2) 8790-2300', 
            'email' => 'communication@redcross.org.ph', 
            'location' => '37 EDSA corner Boni Avenue, Barangka-Ilaya, Mandaluyong City 1550',
            'ref' => 'https://redcross.org.ph/'
        ],
        [
            'name' => 'In Touch Philippines',
            'category' => 'Hotline', 
            'classification' => 'Non-profit Organization',
            'services' => 'In Touch: Crisis Line is a free 24/7 emotional and mental support service offered by In Touch Community Services - a non-profit organisation aiming for overall wellbeing.',            
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8893-1893 | (+63) 917-863-1136 (Globe) | (+63) 998-841-0053 (Smart)', 
            'email' => 'intouch@in-touch.org', 
            'location' => 'In Touch Community Services, 48 McKinley Road, Makati City, Metro Manila, Philippines 1219 (at 2nd floor of Holy Trinity Church Offices)',
            'ref' => 'https://in-touch.org/'
        ],
        [
            'name' => 'Hopeline Philippines by Natasha Goulbourn Foundation (NGF)',
            'category' => 'Hotline', 
            'classification' => 'Non-profit Organization',
            'services' => 'Hopeline Philippines is a free 24/7 suicide prevention and crisis support helpline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 804-4673 (HOPE) | 0917-558-4673 (Globe) | 0918-873-4673 (Smart) | 2919 (toll-free for GLOBE and TM subscribers)', 
            'email' => 'ngfoundation@gmail.com', 
            'location' => 'Makati, Metro Manila, Philippines',
            'ref' => 'https://ngf-mindstrong.com/'
        ],
        [
            'name' => 'Mindcare Club (MCC)',
            'category' => 'Telemental Health', 
            'classification' => 'Private',
            'services' => 'Mindcare Club (MCC) is an NCR-based network of mental health psychiatrists, psychologists, and counselors delivering treatment and therapy through video conference online.',
            'setup' => 'Online',
            'expense' => 'Out of Pocket',
            'number' => '(02) - 8969191 | 0917-854-9191', 
            'email' => 'mindcareclub.triageofficer@gmail.com', 
            'location' => '',
            'ref' => 'https://www.mindcareclub.com'
        ],
        [
            'name' => 'Kapwa MH',
            'category' => 'Telemental Health', 
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
            'name' => 'Lunas Collective',
            'category' => 'Telemental Health', 
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
            'name' => 'Project Kamustahan of Provincial Health Office - Biliran',
            'category' => 'Hotline, Telemental Health', 
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
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'category' => 'Hotline, Telemental Health', 
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya is a government run program by Department of Health and Vicente Sotto Memorial Medical Center that provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '0939-937-5433 or 0939-936-5433 (Smart & SUN) | 0927-654-1629 (Globe/TM)', 
            'email' => 'tawagpaglaumsb@gmail.com', 
            'location' => '',
            'ref' => 'https://www.facebook.com/p/Tawag-Paglaum-Centro-Bisaya-100068862624004/'
        ],
        [
            'name' => 'Dial-A-Friend',
            'category' => 'Hotline, Telemental Health', 
            'classification' => 'Non-profit Organization',
            'services' => 'Dial-A-Friend program aims to provide a friend to talk to about your problems.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(02) 8525-1743 | (02) 8525-1881', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Quezon City Helpline 122',
            'category' => 'Hotline, Telemental Health', 
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
            'category' => 'Hospital, Hotline, Telemental Health', 
            'classification' => 'Government',
            'services' => 'The UP-PGH DPBM aims to produce five-star psychiatrists who are competent as clinicians, educators, researchers, social mobilizers and leaders.',
            'setup' => 'Hybrid',
            'expense' => 'Free | Out of Pocket',
            'number' => '(02) 554-8400 | (02) 8554-88470 | (02) 8526-0150 | (02) 554-8469', 
            'email' => 'pghpsychiatry@gmail.com', 
            'location' => 'PGH Psychiatry and Behavioral Medicine Department 2/F, Ward 7, Taft Avenue, Manila, Metro Manila',
            'ref' => 'https://www.facebook.com/uppgh.dpbm/',
        ],
        [
            'name' => 'Ateneo Bulatao Center For Psychological Services',
            'category' => 'Facility/Clinic, Telemental Health', 
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

    foreach ($dir_resources as &$resource) {
        $resource['number'] = str_replace('|', "<br> ", $resource['number']);
    }
    unset($resource);
?>
</body>
</html>