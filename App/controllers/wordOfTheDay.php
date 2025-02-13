<?php
// URL-ul paginii Word of the Day
$url = "https://www.merriam-webster.com/word-of-the-day";

// extrag HTML-ul
$context = stream_context_create([
    "http" => ["user_agent" => "Mozilla/5.0"]
]);
$html = file_get_contents($url, false, $context);

// incarc HTML-ul in DOMDocument
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

// extrag cuvantul zilei cu ajutorul XPath
$xpath = new DOMXPath($dom);
$wordNode = $xpath->query("//h2[@class='word-header-txt']");

if ($wordNode->length > 0) {
    $word = trim($wordNode[0]->nodeValue);
    echo "Word of the Day: " . $word;
} else {
    echo "Could not find the Word of the Day.";
}
?>
