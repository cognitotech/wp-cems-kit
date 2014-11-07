window.getParameterByName = (name, location = window.location.href) ->
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]")
  regexS = "[\\?&]" + name + "=([^&#]*)"
  regex = new RegExp(regexS)
  results = regex.exec(location)
  unless results?
    ""
  else
    decodeURIComponent results[1].replace(/\+/g, " ")

window.capitalizeValue = (value) ->
  market_source =
    google_ads: "Google Ads"
    facebook_ads: "Facebook Ads"
    gdn: "GDN"
    banner: "Banner"
    hotline: "Hotline"
    live_chats: "Live Chats"
    remarketing: "Remarketing"
    retargeting: "Retargeting"
    youtube_ads: "Youtube Ads"
    Facebook_post: "Facebook Post"

  if market_source[value]
    market_source[value]
  else
    if value
      "Khác"
    else
      ""

jQuery(document).ready ($) ->
  # check if already has source data
  if $('form').length is 0
    return

  if $("input[name$='[customer_source]']").length is 0
    return

  if $("input[name$='[customer_source]']").val().length > 0
    return

  utm_source = window.getParameterByName("utm_source")
  if utm_source.length > 0
    result = window.capitalizeValue(utm_source)
  else
    source = window.getParameterByName("source")
    if source.length > 0
      result = source
    else
      if (window.getParameterByName("ref").length>0 or window.getParameterByName("referral").length>0)
        result = 'referral'
      else
        referrer = document.referrer
        if referrer.length > 0
          utm_source = window.getParameterByName("utm_source",referrer)
          if utm_source.length > 0
            result = window.capitalizeValue(utm_source)
          else
            result = referrer.split('/')[2]

  $("input[name$='[customer_source]']").val result
  return