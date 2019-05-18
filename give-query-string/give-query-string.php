<?php
/*
* Plugin Name: Give Query String
 * Plugin URI:
 * Description: This plugin add's query string parsing functionality to Give donation forms.
 * Version: 1.0
 * Author: Sam Smith
 * Author URI: gsamsmith.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * DISCLAIMER: This is provided as a solution for adding query string field population functionality with the current markup of the Give plugin . We provide no
 * guarantees to and updates that Give may make to their plugin and we do not offer Support for this code at all. For more information please reference the custom development agreement that was signed by both parties.
 *
 */


/**
 * AUTO-POPULATE CONTRIBUTION CODE AND FUND NAME FROM URL STRING
 *
 * This jQuery snippet will auto-populate the Give form contribution code and fund name from a URL you provide
 *
 */

// Hook that fires to initialize.

function give_populate_fund_contribution($form_id)
{
  $forms = array(4664);
  if (in_array($form_id, $forms)) {
    ?>

    <script>
      // use an enclosure so we don't pollute the global space
      (function(window, document, $, undefined) {
        'use strict';
        var giveCustom = {};
        giveCustom.init = function() {
          // Get the contribution code "c" from the URL
          var contributionText = (giveCustom.getQueryVariable("c") !== false) ? decodeURI(giveCustom.getQueryVariable("c")) : '';

          // Get the contribution fund name "f" from the URL
          var fundText = (giveCustom.getQueryVariable("f") !== false) ? decodeURI(giveCustom.getQueryVariable("f")) : 'default';

          // Populate the contribution code text
          if (contributionText !== false && $('#contribution-wrap input').length > 0) {
            $('#contribution-wrap input')
              .val(contributionText);
          }

          // Populate the contribution fund text
          if (fundText !== false && $('#fund-wrap input').length > 0) {
            $('#fund-wrap input')
              .val(fundText);
          }

          // If Fund text exists populate the heading of the donation form. If it's empty fall back to a default value.
          if ((fundText !== '') && (fundText !== 'default')) {
            document.querySelector("h1").innerHTML = fundText;
          } else {
            document.querySelector("h1").innerHTML = "Donation Form";
          }

        }
        giveCustom.getQueryVariable = function(variable) {
          var query = window.location.search.substring(1);
          var vars = query.split("&");
          for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
              return pair[1];
            }
          }
          return (false);
        }
        giveCustom.init();
      })(window, document, jQuery);
    </script>

  <?php
} else {
  return;
}
}

add_action('give_post_form_output', 'give_populate_fund_contribution');
