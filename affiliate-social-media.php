<?php

function affiliate_social_share_buttons($atts) {
    $affiliate_id = get_current_user_id();
    $referral_link = home_url() . '/?ref=' . $affiliate_id;

    ob_start();
    ?>
    <div class="affiliate-social-share">
        <h3>Share Your Referral Link</h3>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($referral_link); ?>" target="_blank">Share on Facebook</a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($referral_link); ?>" target="_blank">Share on Twitter</a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($referral_link); ?>" target="_blank">Share on LinkedIn</a>
        <a href="mailto:?subject=Join%20our%20affiliate%20program&body=<?php echo urlencode($referral_link); ?>">Share via Email</a>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('affiliate_social_share', 'affiliate_social_share_buttons');

?>
