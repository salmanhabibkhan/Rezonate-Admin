<?php
return [
    'validation_error' => 'Validation Error',
    'token_generated_success' => 'Token generated successfully.',
    'channel_name_required' => 'The Channel Name field is required.',
    'to_user_id_required' => 'To user ID is required',
    'user_is_live' => 'User is live',
    'live_stream_ended' => 'Live Stream Ended',
    'is_live_notification' => 'is live',
    'is_calling_you' => 'is calling you',
    'type_required' => 'The Type field is required.',
    'call_history_fetch_success' => 'Call history fetched successfully.',
    'history_not_found' => 'History not found.',
    'stream_not_found' => 'Stream not found.',
    'live_stream_join_success' => 'Live Stream joined successfully.',
    'already_joined_stream' => 'You already joined this stream.',

    'token_fetch_success' => 'Token fetched successfully.',
    'notification_sent_success' => 'Notification sent successfully.',
    'call_declined' => 'declined your call',
    'user_id_required' => 'The user ID field is required.',
    'livestream_request_accepted' => 'accepted livestream request',
    'live_stream_users_fetch_success' => 'Live stream users fetched successfully.',
    'no_live_stream_users_found' => 'No live stream users found.',
    'user_already_in_livestream' => 'User is already in the livestream.',
    'user_added_to_livestream' => 'User added to livestream successfully.',
    'user_not_in_livestream' => 'User is not in the livestream.',
    'user_removed_from_livestream' => 'User removed from livestream successfully.',
    'invalid_choice' => 'Invalid choice.',
    'live_stream_user_found_success' => 'Live stream users found successfully.',
    'user_fetch_success' => 'Users fetched successfully.',
    'user_not_found' => 'User not found.',
    'cannot_send_gift_to_self' => 'You cannot send the gift to yourself.',
    'gift_not_found' => 'Gift not found.',
    'insufficient_balance' => 'Insufficient balance.',
    'gift_sent_success' => 'Gift successfully sent.',
    'gift_id_required' => 'The Gift ID field is required.',
    'call_not_found' => 'Call not found.',
    'unauthenticated' => 'Unauthenticated.',
    'call_deleted_success' => 'Call deleted successfully.',
    'call_id_required' => 'The Call ID field is required.',

    'call_history_deleted_success' => 'Call history deleted successfully.',

    'email_required' => 'The Email field is required.',
    'email_invalid' => 'Please provide a valid email address.',
    'password_required' => 'The Password field is required.',
    'password_min_length' => 'The Password must be at least 6 characters long.',
    'email_password_mismatch' => 'Email or Password do not match.',
    'account_verification' => 'Please check your email for the verification link. Check your spam folder too.',
    'login_success' => 'Login successfully.',


    'email_unique' => 'This email address is already registered. Please use another email.',
    'password_confirm_mismatch' => 'Passwords do not match.',
    'date_of_birth_required' => 'The Date of Birth field is required.',
    'gender_required' => 'The Gender field is required.',
    'registration_success' => 'Registered successfully. Please login.',
    'demo_restriction' => 'You cannot perform this action in demo mode.',
    'file_upload_success' => 'Data updated successfully.',
    'site_logo_upload_error' => 'There was an error uploading the site logo.',
    'favicon_upload_error' => 'There was an error uploading the favicon.',
    'noFriendRequests'=>'No Friend Request Found ',
    'block_self_error' => 'You cannot block yourself.',
    'user_unblocked_success' => 'User unblocked successfully.',
    'user_blocked_success' => 'User blocked successfully.',

    'block_user_fetch_success' => 'Block User Fetch Successfully',
    'block_user_not_found' => 'Block user not found',

    'user_already_reported' => 'You have already reported this user.',
    'user_reported_success' => 'User reported successfully.',
    'report_user_id_required' => 'The Report User ID is required.',
    'reason_required' => 'The Reason field is required.',
    'blog_fetch_success' => 'Blogs fetched successfully.',
    'no_blog_found' => 'No blogs found.',
    'tags_fetch_success' => 'Tags fetched successfully.',

    'blood_request_not_found' => 'Blood request not found.',
    'unauthenticated_error' => 'You are not authorized to delete this blood request.',
    'blood_request_delete_success' => 'Blood request deleted successfully.',

    'messages_fetch_success' => 'Messages fetched successfully.',
    'no_messages_found' => 'No messages found.',
    'error_occurred' => 'An error occurred: {0}',
    'to_id_required' => 'The recipient ID is required.',
    'to_id_integer' => 'The recipient ID must be a valid integer.',

    'chat_list_fetch_success' => 'Chat list fetched successfully.',
    'no_chats_found' => 'No chats found for the given page.',
    'page_id_required' => 'The page ID is required.',
    'page_id_integer' => 'The page ID must be a valid integer.',
    'message_deleted_success' => 'The message has been deleted successfully.',
    'not_allowed_to_delete_message' => 'You are not allowed to delete this message.',
    'message_not_found' => 'Message not found.',
    'chat_users_fetched_success' => 'Chat users fetched successfully.',

    'paypal_deposit_success' => 'Amount using PayPal deposited successfully.',
    'stripe_deposit_success' => 'Amount using Stripe deposited successfully.',
    'paystack_deposit_success' => 'Amount using Paystack deposited successfully.',
    'flutterwave_deposit_success' => 'Amount using Flutterwave deposited successfully.',
    'gateway_id_required' => 'The payment gateway is required.',
    'transaction_id_required' => 'The transaction ID is required.',

    'event_created_success' => 'Event created successfully.',
    
    // Custom validation messages for addEvent
    'name_required' => 'The event name is required.',
    'name_invalid' => 'The event name can only contain alphanumeric characters and spaces.',
    'location_required' => 'The event location is required.',
    'start_date_required' => 'The start date is required.',
    'start_time_required' => 'The start time is required.',
    'end_date_required' => 'The end date is required.',
    'end_time_required' => 'The end time is required.',
    'fetch_events_success' => 'Events fetched successfully.',
    'events_not_found' => 'No events found.',
    'fetch_interested_success' => 'Interested events fetched successfully.',
    'no_interest_events_found' => 'No interested events found.',
    'fetch_going_success' => 'Going events fetched successfully.',
    'going_events_not_found' => 'No going events found.',
    'fetch_my_events_success' => 'My events fetched successfully.',
    'my_events_not_found' => 'No events found for you.',

    'event_id_required' => 'Event ID is required.',
    'interest_marked_as_not_interested' => 'Event marked as not interested.',
    'interest_marked_as_interested' => 'Event marked as interested.',
    'going_marked_as_not_going' => 'Event marked as not going.',
    'going_marked_as_going' => 'Event marked as going.',
    'event_update_success' => 'Event fields updated successfully.',
    'event_update_failure' => 'Failed to update event.',
    'not_allowed' => 'You are not allowed to perform this action.',
    'event_not_found' => 'Event not found.',
    'event_deleted_success' => 'Event deleted successfully.',

    'request_action_required' => 'Request action is required.',
    'friend_request_accepted' => 'Friend request accepted.',
    'friend_request_declined' => 'Friend request declined.',
    'friend_request_not_found' => 'Friend request not found.',
    'userNotFound' => 'User Not found',
    'privacySettings' => 'Unable to proceed with the request due to privacy settings.',
    'requestCancelled' => 'Friend request cancelled.',
    'alreadyFriends' => 'You are already friends.',
    'pendingRequest' => 'You have a pending friend request from this user.',
    'requestSent' => 'Friend request sent successfully.',
    'validationError' => 'Validation Error',
    'apiKeyUnauthorized' => 'Unauthorized',
    'friend_two_required' => 'The friend_two field is required.',

    'request_id_required' => 'The request_id field is required.',
    'requestSuccessfullyDeleted' => 'Friend request successfully deleted.',
    'requestNotFound' => 'Friend request not found.',
    'unfriendSuccess' => 'Unfriend successfully.',
    'friendRequestNotFound' => 'Friend request not found.',
    'noRecommendations' => 'No recommendations found.',
    'recommendationsFound' => 'Recommendations found.',
    'role_updated_success'=>'Friend role updated ',
    'friend_list_fetch'=>'Friends List Successfully Retrieved',
    'friend_not_found'=>'You Currently Have No Friends.',
    'sent_requests_fetched' => 'Sent requests successfully fetched.',
    'no_sent_requests' => 'You have no sent requests.',

    'fetch_games_success' => 'Games data fetched successfully.',
    'no_games_found' => 'No games found.',


    'groups_fetched_successfully' => 'Groups fetched successfully.',
    'no_groups_found' => 'No groups found.',
    'user_groups_fetched_successfully' => 'User groups fetched successfully.',
    'no_user_groups_found' => 'No user groups found.',

    'group_title_required' => 'Group title is required.',
    'group_title_invalid_characters' => 'Group title contains invalid characters.',
    'about_group_required' => 'About group is required.',
    'category_required' => 'Category is required.',
    'privacy_required' => 'Privacy setting is required.',
    'group_created_successfully' => 'Group created successfully.',

    'group_id_required' => 'Group ID is required.',
    'group_data_fetch_success' => 'Group data fetched successfully.',
    'group_data_not_found' => 'Group data not found.',
    'group_update_success' => 'Group fields updated successfully.',
    'unauthorized_access' => 'You are not allowed to perform this action.',
    'group_not_found' => 'Group not found.',

    'already_member' => 'You are already a member of this group.',
    'group_join_success' => 'Group joined successfully.',
    'not_member' => 'You are not a member of the group.',
    'group_left_success' => 'Successfully left the group.',

    'no_data_found' => 'No data found.',
    'member_already_in_group' => 'This member is already in the group.',
    'member_added_successfully' => 'Member added successfully.',
    'user_not_member' => 'This user is not a member of the group.',
    'member_removed_successfully' => 'Member removed successfully.',

    'group_members_fetched_successfully' => 'Group members fetched successfully.',
    'group_members_not_found' => 'Group members not found.',
    'admin_creation_success' => 'Group admin created successfully.',

    'not_group_admin' => 'This user is not an admin of the group.',
    'admin_dismiss_success' => 'Group admin dismissed successfully.',
    'groups_fetch_success' => 'Groups fetched successfully.',
    'user_groups_not_found' => 'User groups not found.',

    'job_id_required' => 'Job ID is required',
    'job_title_required' => 'Job title is required.',
    'job_description_required' => 'Job description is required.',
    'job_location_required' => 'Job location is required.',
    'minimum_salary_required' => 'Minimum salary is required.',
    'maximum_salary_required' => 'Maximum salary is required.',
    'currency_required' => 'Currency is required.',
    'salary_date_required' => 'Salary date is required.',
    'experience_years_required' => 'Experience years are required.',
    'my_jobs_fetched_successfully' => 'My jobs fetched successfully.',
    'all_jobs_fetched_successfully' => 'All jobs fetched successfully.',
    'no_job_found' => 'No job found.',
    'application_successful' => 'Application submitted successfully.',
    'already_applied' => 'You have already applied for this job.',
    'job_id_integer' => 'The job ID must be an integer.',
    'phone_required' => 'The phone number is required.',
    'phone_invalid' => 'The phone number is invalid.',
    'cv_file_optional' => 'CV file is optional.',
    'cv_file_uploaded' => 'CV file must be uploaded.',
    'cv_file_max_size' => 'CV file size must not exceed 2MB.',
    'cv_file_mime_in' => 'CV file must be a PDF or Word document.',
    'applied_successfully' => 'Applied successfully.',
    'already_applied_for_job' => 'You have already applied for this job.',
    'search_parameters_missing' => 'Please input the type or title of the job.',
    'search_success' => 'Search jobs found successfully.',
    'no_jobs_found' => 'No job found.',
    'job_update_success' => 'Job fields updated successfully.',
    'unauthorized' => 'You are not allowed.',
    'job_not_found' => 'Job not found.',
    'job_categories_fetch_success' => 'Job Categories fetched successfully.',
    'no_job_category_found' => 'No job categories found.',

    'fetch_applied_candidates_success' => 'Fetch applied candidates successfully.',
    'candidates_not_found' => 'Candidates not found.',
    'fetch_notifications_success' => 'Fetch notifications successfully.',
    'no_notifications_found' => 'No notifications found.',
    'notifications_list_success' => 'Notifications list fetched successfully.',
    'all_notifications_marked_as_read' => 'All notifications have been marked as read.',
    'all_notifications_deleted_successfully' => 'All notifications have been deleted successfully.',
    'notification_not_found' => 'Notification not found',
    'notification_deleted_successfully' => 'Notification deleted successfully',
    'notification_updated_successfully' => 'Notification updated successfully.',
    'job_deleted_successfully' => 'The job is deleted successfully.',
    'transaction_failed' => 'Transaction failed.',

    'page_created_successfully' => 'The page is created successfully',
    'page_title_required' => 'Page title is required',
    'page_title_min_length' => 'Page title must be at least 5 characters long',
    'page_title_max_length' => 'Page title cannot exceed 50 characters',
    'page_title_invalid_characters' => 'Page title contains invalid characters',
    'page_description_required' => 'Page description is required',
    'page_category_required' => 'Page category is required',
    'page_deleted_successfully' => 'The page is deleted successfully',
    'page_not_found' => 'Page not found',
    'permission_denied' => 'You do not have permission to update this page',
    'page_updated_successfully' => 'Page fields updated successfully',
    'email_subject' => 'Liked Your Page',
    'email_body_liked_page' => 'Someone liked your page.',
    'notification_liked_page' => 'liked your page.',
    'push_notification_liked_page' => 'liked your page',
    'page_successfully_liked' => 'Page successfully liked.',
    'page_successfully_unliked' => 'Page successfully unliked.',
    'fetch_liked_pages_success' => 'Fetch liked pages successfully',
    'no_liked_pages_found' => 'No liked pages found',

    'deleted_user_id_required' => 'The Deleted User ID is required.',
    'pages_fetch_success' => 'Pages fetched successfully.',
    'user_removed' => 'User has been removed successfully.',

    'post_text_required' => 'Post text is required.',
    'input_required' => 'At least one of post text, images, audio, or video is required.',
    'not_a_group_member' => 'You are not a member of the group.',
    'post_created_success'=>'Post created successfully',
    'post_detail'=>'Post Detail',
    'post_saved_list'=>'Posts saved List',
    'success'=>'Success',
    'post_id' => 'Post ID',
    'post_id_required' => 'The Post ID is required.',
    'validation_failed' => 'Validation failed.',
    'post_not_found' => 'Post does not exist.',
    'post_detail_fetched' => 'Post detail fetched successfully.',
    'post_deleted_successfully' => 'Post deleted successfully.',
    'unauthorized_to_delete_post' => 'You are not authorized to delete this post.',

    'post_id_numeric' => 'Post ID must be numeric.',
    'ad_title' => 'Advertisement Title',
    'title_required' => 'The title is required.',
    'title_max_length' => 'The title cannot exceed 150 characters.',
    'ad_link' => 'Advertisement Link',
    'link_required' => 'The link is required.',
    'link_max_length' => 'The link cannot exceed 200 characters.',
    'ad_body' => 'Advertisement Body',
    'body_required' => 'The body is required.',
    'body_max_length' => 'The body cannot exceed 250 characters.',
    'image_upload_failed' => 'Failed to upload image.',
    'advertisement_added_successfully' => 'Advertisement added successfully.',
    'failed_to_add_advertisement' => 'Failed to add advertisement.',
    'comment_text' => 'Comment Text',
    'comment_text_required' => 'Comment text is required.',
    'comment_added_successfully' => 'Comment added successfully.',
    'failed_to_add_comment' => 'Failed to add comment.',
    'commented_on_post' => 'commented on your post.',
    'post_comment' => 'Post Comment',

    'comments_fetched' => 'Comments fetched successfully.',
    'comments_not_found' => 'No comments found for this post.',
    'comment_id' => 'Comment ID',
    'comment_id_required' => 'Comment ID is required.',
    'comment_id_numeric' => 'Comment ID must be numeric.',
    'comment_liked' => 'Comment liked successfully.',
    'comment_unliked' => 'You have unliked the comment.',
    'like_failed' => 'Failed to like the comment.',
    'new_comment_text' => 'New Comment Text',
    'new_comment_text_required' => 'Comment text is required.',
    'new_comment_text_string' => 'Comment text must be a valid string.',
    'comment_not_found' => 'Comment not found.',
    'comment_update_permission_denied' => 'You do not have permission to update this comment.',
    'comment_updated_success' => 'Comment updated successfully.',
    'comment_update_failed' => 'Failed to update Comment.',
    'reply_text' => 'Reply Text',
    'reply_text_required' => 'Reply text is required.',
    'reply_text_string' => 'Reply text must be a valid string.',
    'reply_added_successfully' => 'Reply added successfully.',  'comment_reply_id' => 'Comment Reply ID',
    'comment_reply_id_required' => 'Comment Reply ID is required.',
    'comment_reply_id_numeric' => 'Comment Reply ID must be numeric.',
    'already_liked_comment_reply' => 'You have already liked this comment reply.',
    'comment_reply_liked_successfully' => 'Comment reply liked successfully.',
    'comment_reply_like_failed' => 'Failed to like comment reply.',
    'reply_failed' => 'Failed to add reply to the comment.',
    'post_shared_success' => 'The post was shared successfully',
    'shared_your_post' => 'shared your post',
    'share_post_subject' => 'Share Post',
    'server_error' => 'An internal server error occurred',

    'comment_deleted_success' => 'Comment deleted successfully.',

    'post_saved_success' => 'Post saved successfully.',
    'saved_post_deleted_success' => 'Saved post deleted successfully.',
    'action' => 'Action',
    'action_required' => 'Action is required.',
    'post_deleted_success' => 'Post deleted successfully.',
    'unauthorized_delete' => 'You are not authorized to delete this post.',
    'invalid_action' => 'Invalid action.',

    'post_reported_success' => 'Post reported successfully.',
    'post_already_reported' => 'You have already reported this post.',
    'comments_disabled_success' => 'Comments disabled successfully.',
    'comments_enabled_success' => 'Comments enabled successfully.',
    'unauthorized_action' => 'You are not authorized to perform this action.',
    'reaction_removed_success' => 'Reaction removed successfully.',
    'reaction_updated_success' => 'Reaction updated successfully.',
    'post_reaction_added_success' => 'Post reaction added successfully.',

    'reacted_on_your_post' => 'reacted on your post.',
    'post_reaction_not_found' => 'Post Reaction Not found',

    'shared_post_deleted' => 'The shared post has been deleted.',
    'reply_id_required' => 'The reply ID is required.',
    'reply_deleted_success' => 'The comment reply is deleted successfully.',
    'comment_required' => 'The comment text is required.',
    'comment_reply_created_success' => 'Comment reply created successfully.',

    'comment_replies_success' => 'Comment replies retrieved successfully.',
    'great_job_already_assigned' => 'Great Job already assigned.',
    'own_post_great_job' => 'This is your own post.',
    'insufficient_balance_great_job' => 'Insufficient balance for awarding Great Job.',
    'great_job_awarded_success' => 'Great Job awarded successfully.',

    'insufficient_balance_coc' => 'Insufficient balance for awarding Cup of Coffee.',
    'coc_already_assigned' => 'Cup of Coffee already assigned.',
    'cannot_award_own_post_coc' => "You can't award Cup of Coffee to your own post.",
    'cup_of_coffee_awarded_success' => 'Cup of Coffee awarded successfully.',

    'error' => 'Error',
    'ad_not_found' => 'Ad not found',

    // Ad approval/rejection messages
    'ad_approved' => 'Your ad request has been approved',
    'ad_approve_success' => 'Ad request approved successfully',
    'ad_not_approved_balance' => 'Your ad request has not been approved due to insufficient balance.',
    'ad_approve_fail_balance' => 'Ad request cannot be approved due to insufficient balance',
    'ad_rejected' => 'Your ad request is rejected',
    'ad_reject_success' => 'Ad request rejected successfully',

    // Validation messages
    'ad_id_required' => 'The ad ID is required',
  
   'privacy_changed' => 'Post privacy changed to {privacy}',

   // Privacy types
   'privacy_public' => 'Public',
   'privacy_friends' => 'Friends',
   'privacy_only_me' => 'Only Me',
   'privacy_family' => 'Family',
   'privacy_business' => 'Business',
    'post_updated' => 'Post is updated',

    'advertisement_request_fetch_success' => 'Post advertisement request fetched successfully',
    'advertisement_request_not_found' => 'Post advertisement request not found',

    // Status messages
    'status_pending' => 'Pending',
    'status_approved' => 'Approved',
    'status_rejected' => 'Rejected',


        // Validation messages
    'poll_id_required' => 'The poll ID is required',
    'poll_id_integer' => 'The poll ID must be an integer',
    'poll_option_id_required' => 'The poll option ID is required',
    'poll_option_id_integer' => 'The poll option ID must be an integer',

    // Poll-related messages
    'poll_not_found' => 'Poll not found',
    'poll_option_not_found' => 'Poll option not found',
    'already_voted' => 'You have already voted, you cannot vote again',
    'vote_successful' => 'Voted successfully',

    'trending_hashtags_found' => 'Trending hashtags found successfully',
    'trending_hashtags_not_exist' => 'Trending hashtags do not exist',

    'amount_required' => 'The amount is required',

    // Post feed messages
    'cannot_feed_own_post' => 'You cannot feed your own post',

    'product_name_required' => 'Product name is required',
    'product_description_required' => 'Product description is required',
    'price_required' => 'Price is required',
    'units_required' => 'Units are required',
    'images_required' => 'Product images are required',
    'images_ext_in' => 'The images must be of type: png, jpg, jpeg',
    'images_is_image' => 'The file must be a valid image',

    // General messages
    'product_added_successfully' => 'Product added successfully',
    'internal_server_error' => 'Internal Server Error',
    'validation_errors' => 'Validation errors',
    'post_feded_successfully' => 'Post fed successfully',
    'product_not_found' => 'Product not found',
    'fetch_user_product_success' => 'Fetch User Product Successfully',
    'invalid_user_id' => 'Invalid User Id',
    'product_id_required' => 'Product ID is required',

    'product_updated_successfully' => 'Product fields updated successfully',
    'product_deleted_successfully' => 'The product is deleted',
    'privacy_integer' => 'The privacy setting must be an integer',
    'description_required' => 'The description is required',
    'space_created_successfully' => 'Space is created successfully',

    'space_id_required' => 'Space ID is required',

    // Space messages
    'space_updated_successfully' => 'Space fields updated successfully',
    'space_not_found' => 'Space not found',


    // Success messages
    'space_deleted_successfully' => 'Space deleted successfully',

    // Error messages

    // Space messages
    'cannot_join_own_space' => 'You cannot join your own space',
    'already_member_of_space' => 'You are already a member of this space',
    'space_joined_successfully' => 'Space joined successfully',
    'not_member_of_space' => 'You are not a member of this space',
    'space_left_successfully' => 'Space left successfully',

    // Co-host related messages
    'already_cohost' => 'You are already a Co-host of this space',
    'cohost_created_successfully' => 'Co-host created successfully',
    'user_not_member_of_space' => 'The user is not a member of this space',

    // Co-host related messages
    'cohost_removed_successfully' => 'Co-host removed successfully',
    'not_a_cohost' => 'The user is not a Co-host of this space',

    // General messages
    'spaces_fetched_successfully' => 'Spaces fetched successfully',

    'spaces_data_fetched_successfully' => 'Spaces data fetched successfully',
    'story_created_successfully' => 'The story is created successfully',
    'stories_fetched_successfully' => 'The stories fetch successfully',

    'user_muted_successfully' => 'The user has been muted successfully',
    'user_unmuted_successfully' => 'The user has been unmuted successfully',
    'story_id_required' => 'The story ID field is required.',
    'own_story' => 'This is your own story',
    'story_seen_successfully' => 'The story has been seen successfully',
    'story_already_seen' => 'The story has already been seen',
    'viewed_story_notification' => 'viewed your story.',
    'viewed_story_email_subject' => 'Viewed Story',
    'viewed_story_email_body' => 'has viewed your story',

    'story_seen_user_fetch_successfully' => 'Story Seen user fetched successfully',
    'no_views_found' => 'No views found',
    'story_deleted_successfully' => 'The story deleted successfully',
    'story_not_found' => 'Story Not Found',

    'blocked_user' => 'Blocked User',
    'user_profile_fetch_successfully' => 'User Profile fetched successfully',
    'profile_not_found' => 'Profile Not found',
    'viewed_your_profile' => 'viewed your profile',
    'view_profile_subject' => 'View Profile',
    'view_profile_text' => 'viewed your profile',

    'search_user_fetch_successfully' => 'Search User fetched successfully',

    'search_group_fetch_successfully' => 'Search Group fetched successfully',
    'search_events_successfully' => 'Search events successfully',
    'search_jobs_successfully' => 'Search jobs successfully',
    'package_not_exist' => 'Package does not exist',
    'already_subscribed' => 'You are already subscribed to a higher or equal-tier package.',
    'subscription_success' => 'Package subscription successful.',



    'package_id_label' => 'Package ID',
    'package_id_required' => 'Package ID is required.',
    'package_upgrade_not_allowed' => 'We cannot upgrade this package as your higher-tier subscription is already active.',
    'package_subscription_success' => 'Package Subscription Successfully.',
    'package_already_subscribed' => 'Package Already subscribed.',

    'account_deletion_not_available' => 'Account deletion is not available.',
    'incorrect_password' => 'Incorrect Password.',
    'account_deleted_successfully' => 'Account is deleted successfully.',
    'account_deletion_failed' => 'Account deletion failed',
    'user_fetch_successfully' => 'user Fetch successfully',
    'pro_user_not_found' => 'Pro user not found.',
    'poke_successfully' => 'Poked successfully',
    'poked_you' =>'poked you',

    'blood_donor_found' => 'Blood Donor found successfully',
    'blood_donor_not_found' => 'Blood Donor not found',
    'blood_request_added_successfully' => 'Blood Request added Successfully',
    'blood_group_required' => 'Blood group is required.',
    'cannot_transfer_to_self' => 'Cannot transfer to your own account',
    'amount_transferred_successfully' => 'Amount transferred successfully',
    'transfer_failed_due_to' => 'Amount cannot be transferred due to: ',
    'fund_id_required' => 'Fund ID is required',
    'donation_not_found' => 'Donation not found',
    'donation_successful' => 'Donated successfully',
    'donation_failed_due_to' => 'Amount cannot be transferred due to: ',
    'profile_updated_successfully'=>'Profile updated successfully',
    'admin_withdraw_error'=>'Admin can not create withdraw',
    'paypal_withdraw_success'=>'Withdraw using paypal created successfully',

    'bank_withdraw_success'=>'Withdraw using bank created successfully',



    'minimum_less_than_maximum' => 'Minimum salary must be less than the maximum salary.',
    'job_title_invalid' => 'The job title can only contain English letters and spaces.',



























];
