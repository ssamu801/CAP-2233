<!DOCTYPE html>
<html>
<body>

<?php
    $dir_resources = [
        [
            'name' => 'National Center for Mental Health (NCMH)', 
            'category' => 'Hospital, Hotline',
            'classification' => 'Government',
            'services' => 'Consultation, Counseling/Therapy, Emergency Services, Information Dissemination, Medication, Psychological Assessment, Training',
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
            'services' => 'Consultation, Counseling/Therapy, Emergency Services, Medication, Training',
            'setup' => 'Online',
            'expense' => 'Out of Pocket',
            'number' => '(+63 2) 8839-2525', 
            'email' => 'customercare@lifeline.com.ph', 
            'location' => 'Valgosons Building, Lifeline Compound, 8484 East Service Road, Km. 18, Sucat, Parañaque City, Philippines 1700',
            'ref' => 'https://www.lifeline.com.ph/'
        ],
        [
            'name' => 'Center for the Prevention & Treatment of Child Sexual Abuse (CPTCSA)',
            'category' => 'Hotline', 
            'classification' => 'Non-government',
            'services' => 'CPTCSA offers free online care and support to those in need of emotional assistance and guidance. They are accessible from Mondays to Fridays 8AM to 5PM.',
            'setup' => 'Online',
            'expense' => 'Free',
            'number' => '(+63 2) 8426-7839 | (+63 2) 8985-0234 | 0961-718-2655 | 0977-652-0230', 
            'email' => 'cptcsa20@gmail.com', 
            'location' => '#19 Magiting Street, Teacher\'s Village, Quezon City 1101 Philippines',
            'ref' => 'https://cptcsaph.org/'
        ],
        [
            'name' => 'Philippine Red Cross',
            'category' => 'Advocacy Group, Facility/Clinic, Hotline', 
            'classification' => 'Non-government',
            'services' => 'The Philippine Red Cross provides six major services: Blood Services, Disaster Management Services, Safety Services, Health Services, Social Services, Red Cross Youth and Volunteer Services.',
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
            'classification' => 'Non-government',
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
            'classification' => 'Non-government',
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
            'classification' => '',
            'services' => 'Mindcare Club (MCC) is an NCR-based network of mental health psychiatrists, psychologists, and counselors delivering treatment and therapy through video conference online.',
            'setup' => '',
            'expense' => '',
            'number' => '(02) - 8969191 | 0917-854-9191', 
            'email' => '', 
            'location' => '',
            'ref' => 'https://www.mindcareclub.com'
        ],
        [
            'name' => 'Kapwa MH',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Lunas Collective',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Project Kamustahan of Provincial Health Office - Biliran',
            'category' => 'Hotline, Telemental Health', 
            'classification' => 'Government',
            'services' => '',
            'setup' => 'Hybrid',
            'expense' => 'Free',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Tawag Paglaum-Centro Bisaya',
            'category' => 'Hotline', 
            'classification' => 'Government',
            'services' => 'Tawag Paglaum-Centro Bisaya provides 24/7 suicide, depression, and emotional crisis intervention hotline',
            'setup' => '',
            'expense' => '',
            'number' => '0939-9375433 or 0939-9365433 (Smart & SUN) | 0927-6541629 (Globe/TM)', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Mood Harmony',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '(02) 8844-2941', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Dial-a-Friend',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '(02) 8525-1743 | (02) 8525-1881', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => 'Suicide Crisis Lines',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => '',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => '',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
        [
            'name' => '',
            'category' => '', 
            'classification' => '',
            'services' => '',
            'setup' => '',
            'expense' => '',
            'number' => '', 
            'email' => '', 
            'location' => ''
        ],
    ];

    foreach ($dir_resources as &$resource) {
        $resource['number'] = str_replace('|', "<br> ", $resource['number']);
    }
    unset($resource);
?>
</body>
</html>