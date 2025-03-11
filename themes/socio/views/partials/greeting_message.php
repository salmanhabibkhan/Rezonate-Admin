<?php
$hour = date('G'); // Get the current hour in 24-hour format
$morningMessages = [
    lang('Web.morning_message_1'),
    lang('Web.morning_message_2'),
    lang('Web.morning_message_3'),
    lang('Web.morning_message_4'),
    lang('Web.morning_message_5'),
    lang('Web.morning_message_6')
];

$afternoonMessages = [
    lang('Web.afternoon_message_1'),
    lang('Web.afternoon_message_2'),
    lang('Web.afternoon_message_3'),
    lang('Web.afternoon_message_4'),
    lang('Web.afternoon_message_5')
];

$eveningMessages = [
    lang('Web.evening_message_1'),
    lang('Web.evening_message_2'),
    lang('Web.evening_message_3'),
    lang('Web.evening_message_4'),
    lang('Web.evening_message_5')
];

$nightMessages = [
    lang('Web.night_message_1'),
    lang('Web.night_message_2'),
    lang('Web.night_message_3'),
    lang('Web.night_message_4'),
    lang('Web.night_message_5')
];

if ($hour >= 5 && $hour < 12) {
    $greeting = lang('Web.good_morning');
    $message = $morningMessages[array_rand($morningMessages)];
    $icon = 'bi-brightness-high';
    $color = '#ffc107';
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = lang('Web.good_afternoon');
    $message = $afternoonMessages[array_rand($afternoonMessages)];
    $icon = 'bi-sun';
    $color = '#ff5733';
} elseif ($hour >= 17 && $hour < 21) {
    $greeting = lang('Web.good_evening');
    $message = $eveningMessages[array_rand($eveningMessages)];
    $icon = 'bi-moon-stars';
    $color = '#9370DB';
} else {
    $message = $nightMessages[array_rand($nightMessages)];
    $greeting = lang('Web.good_night');
    $icon = 'bi-moon';
    $color = '#000000';
}

if (get_setting('chck-afternoon_system') == 1) {
?>
<div class="greetings_message">
    <div class="card daytime_message" style="border-left: 3px solid <?=$color?>;">
        <button type="button" class="btn-close greeting_close" aria-label="Close"></button>
        <i class="<?= esc($icon) ?> greeting-icon" style="color:<?=$color?>"></i>
        <div>
            <h5><?= esc($greeting) ?>, <?=$user_data['first_name']." ".$user_data['last_name']?></h5>
            <p><?= $message ?></p>
        </div>
    </div>
</div>
<?php } ?>
