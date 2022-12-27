<?php

const QUERIES = [
    "add_user" => "INSERT INTO user (username, `password`, `name`, surname, email, phone, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?)",
    "delete_user" => "DELETE FROM user WHERE username = ?",
    "check_username" => "SELECT * FROM user WHERE username = ?",
    "check_password" => "SELECT * FROM user WHERE username = ? AND `password` = ?",
    "get_feed_posts" => "SELECT * FROM post WHERE username IN (SELECT to_username FROM `following` WHERE from_username = ?) ORDER BY `timestamp` DESC",
    "like_post" => "INSERT INTO post_like (post_id, username) VALUES (?, ?)",
    "unlike_post" => "DELETE FROM post_like WHERE post_id = ? AND username = ?",
    "get_post_likes" => "SELECT * FROM post_like WHERE post_id = ? ORDER BY `timestamp` DESC",
    "comment_post" => "INSERT INTO comment (post_id, `text`, username) VALUES (?, ?, ?)",
    "delete_comment" => "DELETE FROM comment WHERE comment_id = ?",
    "get_post_comments" => "SELECT * FROM comment WHERE post_id = ? ORDER BY `timestamp` DESC",
    "add_post" => "INSERT INTO post (caption, username) VALUES (?, ?)",
    "delete_post" => "DELETE FROM post WHERE post_id = ?",
    "get_user_posts" => "SELECT * FROM post WHERE username = ? ORDER BY `timestamp` DESC",
    "like_comment" => "INSERT INTO comment_like (comment_id, username) VALUES (?, ?)",
    "unlike_comment" => "DELETE FROM comment_like WHERE comment_id = ? AND username = ?",
    "rate_post" => "INSERT INTO post_rating (post_id, username, exposure, colors, composition) VALUES (?, ?, ?, ?, ?)",
    "update_average_post_rating" => "UPDATE post SET average_exposure_rating = (SELECT AVG(exposure) FROM post_rating WHERE post_id = ?), average_colors_rating = (SELECT AVG(colors) FROM post_rating WHERE post_id = ?), average_composition_rating = (SELECT AVG(composition) FROM post_rating WHERE post_id = ?) WHERE post_id = ?",
    "get_average_post_rating" => "SELECT average_exposure_rating, average_colors_rating, average_composition_rating FROM post WHERE post_id = ?",
    "get_user_average_post_rating" => "SELECT AVG(average_exposure_rating), AVG(average_colors_rating), AVG(average_composition_rating) FROM post WHERE username = ?",
    "get_post_images" => "SELECT * FROM post_image WHERE post_id = ?",
    "add_post_image" => "INSERT INTO post_image (post_id, position, `image`) VALUES (?, ?, ?)",
    "get_user_notifications" => "SELECT * FROM notification WHERE username = ? ORDER BY `timestamp` DESC",
    "set_notifications_seen" => "UPDATE notification SET seen = 1 WHERE notification_id IN (?)",
    "delete_notification" => "DELETE FROM notification WHERE notification_id = ?",
    "clear_user_notifications" => "DELETE FROM notification WHERE username = ?",
    "send_notification" => "INSERT INTO notification (`text`, seen, username) VALUES (?, ?, ?)",
    "get_user_profile_image" => "SELECT profile_image FROM user WHERE username = ?",
];
