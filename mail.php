<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

//get values possibly submitted by form
$email      = sanitize_email( $_POST['email'] );
$cname      = sanitize_text_field( $_POST['cname'] );
$subject    = sanitize_text_field( $_POST['subject'] );
$message    = sanitize_text_field( $_POST['message'] );
$sendemail  = !empty( $_POST['sendemail'] );

// form submitted?
if ( ! empty( $sendemail ) && ! empty( $cname ) && ! empty( $email ) ) {

    $mailto = get_bloginfo( 'admin_email' );
    $mailsubj = $subject;
    //$mail->setFrom($email, 'Admin');
    $mailhead = array( 
                    'Content-Type: text/html; charset=UTF-8',
                    'From: Admin <' . $email . '>' . "\r\n;",
                );
    $mailbody = "Name: " . $cname . "\n\n";
    $mailbody .= "Email: $email\n\n";
    $mailbody .= "Message:\n" . $message;

    // send email to us
    wp_mail( $mailto, $mailsubj, $mailbody, $mailhead );

    // set message for this page and clear vars
    $msg = "Your message has been sent.";

    $email = "";
    $cname = "";
    $subject = "";
    $message = "";
} 
elseif (! empty( $sendemail ) && ! is_email( $email ) ) {
    $msg = "Please enter a valid email address.";
}
elseif ( ! empty( $sendemail ) && empty( $cname ) ) {
    $msg = "Please enter your name.";
}
elseif ( ! empty( $sendemail ) && ! empty( $cname ) && empty( $email ) ) {
    $msg = "Please enter your email address.";
}

// get the header
get_header();

get_footer();
