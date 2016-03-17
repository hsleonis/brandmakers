<?php
 $data = json_decode(file_get_contents("php://input"));
 if(!$data) die();
 $sub = $data->sub;
 
function mailchecker($data){
    $arr = array();
    if($data->email===''||$data->email===null||filter_var($data->email, FILTER_VALIDATE_EMAIL) === false) {
        array_push($arr,'Invalid email.');
    }
    if(strlen($data->message)<11) {
        array_push($arr,'Message must be more than 10 characters.');
    }
    if(strlen($data->name)<6) {
        array_push($arr,'Name must be more than 5 characters.');
    }
    return $arr;
}

if($sub=='contact') {
    $checked = mailchecker($data);
    if(count($checked)>0) {
        echo '<ul>';
        foreach($checked as $val){
            echo '<li>'.$val.'</li>';
        }
        echo '</ul>';
    }
    else {
        $to = "shahriar@dcastalia.com";
        $subject = 'Brand Maker Contact';
        $headers = "From: ". filter_var($data->email, FILTER_SANITIZE_EMAIL) . "\r\n";
        $headers .= "Reply-To: ". filter_var($data->email, FILTER_SANITIZE_EMAIL) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        $message = '<html><body>';
        $message .= '<img style="margin-bottom:20px;" src="http://162.144.89.76/projects/web/brand/resources/img/logo.png" alt="Brand Maker" />';
        $message .= '<table rules="all" cellpadding="10" border="0">';
        $message .= "<tr style='background: #8F6B46;'><td style='border:0;'><strong>Name:</strong> </td><td style='border:0;'>" . filter_var($data->name, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "<tr style='background: #B48E67;'><td style='border:0;'><strong>Subject:</strong> </td><td style='border:0;'>" . filter_var($data->topic, FILTER_SANITIZE_EMAIL) . "</td></tr>";
        $message .= "<tr style='background: #DCBC9C;'><td style='border:0;'><strong>Message:</strong> </td><td style='border:0;'>" . filter_var($data->message, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

        mail($to,$subject,$message,$headers);
        echo 'Mail successfully sent';
    }
}
else if($sub=='career') {
    $checked = mailchecker($data);
    if(count($checked)>0) {
        echo '<ul>';
        foreach($checked as $val){
            echo '<li>'.$val.'</li>';
        }
        echo '</ul>';
    }
    else {
        $to = "shahriar@dcastalia.com";
        $subject = 'BASE Career';
        $headers = "From: ". filter_var($data->email, FILTER_SANITIZE_EMAIL) . "\r\n";
        $headers .= "Reply-To: ". filter_var($data->email, FILTER_SANITIZE_EMAIL) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        $message = '<html><style>td{border:#DDD;border-collapse:collapse;}</style><body>';
        $message .= '<div style="margin:auto;padding-bottom:10px;"><img src="http://base-technologies.net/demo/resources/img/logo.png" alt="BASE technologies" /></div>';
        $message .= '<table rules="all" style="border-color: #ddd;" cellpadding="10">';
        $message .= "<tr><td style='border-color: #ddd;'><strong>Name:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->name, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "<tr><td style='border-color: #ddd;'><strong>Email:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->email, FILTER_SANITIZE_EMAIL) . "</td></tr>";
        $message .= "<tr><td style='border-color: #ddd;'><strong>Present Address:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->address, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "<tr><td style='border-color: #ddd;'><strong>Qualification:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->qualification, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "<tr><td style='border-color: #ddd;'><strong>Position Applying for:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->job, FILTER_SANITIZE_STRING) . "</td></tr>";
        $message .= "<tr><td style='border-color: #ddd;'><strong>Message:</strong> </td><td style='border-color: #ddd;'>" . filter_var($data->message, FILTER_SANITIZE_STRING) . "</td></tr>";
        if($data->cv!==''||$data->cv!==null)
        $message .= "<tr><td style='border-color: #ddd;'><strong>Attachment:</strong> </td><td style='border-color: #ddd;'><a href='" . filter_var($data->cv, FILTER_SANITIZE_URL) . "' target='_blank'>Download</a></td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

        mail($to,$subject,$message,$headers);
        echo 'Mail successfully sent';
    }
}