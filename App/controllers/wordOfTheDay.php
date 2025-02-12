<?php
// URL of the Word of the Day page
$url = "https://www.merriam-webster.com/word-of-the-day";

// Fetch the HTML content
$context = stream_context_create([
    "http" => ["user_agent" => "Mozilla/5.0"]
]);
$html = file_get_contents($url, false, $context);

// Load the HTML into DOMDocument
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Suppress warnings
$dom->loadHTML($html);
libxml_clear_errors();

// Use XPath to extract the word of the day
$xpath = new DOMXPath($dom);
$wordNode = $xpath->query("//h2[@class='word-header-txt']");

if ($wordNode->length > 0) {
    $word = trim($wordNode[0]->nodeValue);
    echo "Word of the Day: " . $word;
} else {
    echo "Could not find the Word of the Day.";
}
?>
