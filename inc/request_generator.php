<?php

include "../settings/config.php";

// The region you are interested in
$endpoint = "webservices.amazon.com";

$uri = "/onca/xml";

$params = array(
    "Service" => "AWSECommerceService",
    "Operation" => "ItemSearch",
    "AWSAccessKeyId" => AWS_API_KEY,
    "AssociateTag" => AWS_ASSOCIATE_TAG,
    "SearchIndex" => "Electronics",
    "Keywords" => "watch",
    "ResponseGroup" => "Images,ItemAttributes,Offers",
    "Sort" => "salesrank",
	//"ContentType" => "text/html",
	"ItemPage" => "2"
);

// Set current timestamp if not set
if (!isset($params["Timestamp"])) {
    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
}

// Sort the parameters by key
ksort($params);

$pairs = array();

foreach ($params as $key => $value) {
    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}

// Generate the canonical query
$canonical_query_string = join("&", $pairs);

// Generate the string to be signed
$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

// Generate the signature required by the Product Advertising API
$signature = base64_encode(hash_hmac("sha256", $string_to_sign, AWS_API_SECRET_KEY, true));

// Generate the signed URL
$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

echo "Signed URL: \"".$request_url."\" \n";

echo "<a href=\"".$request_url."\">Link</a>";

?>
