<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Integration</title>
</head>
<body>

<div id="chat-container">
    <div id="chat-display"></div>
    <input type="text" id="user-input" placeholder="Type your message...">
    <button onclick="sendMessage()">Send</button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    // Include your OpenAI API key here
    const apiKey = "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";

    // Function to send user message to OpenAI and display the response
    async function sendMessage() {
        const userInput = document.getElementById("user-input").value;
        const chatDisplay = document.getElementById("chat-display");

        // Display user message
        chatDisplay.innerHTML += `<p>User: ${userInput}</p>`;

        // Call OpenAI API to get AI response
        const aiResponse = await getChatGPTResponse(userInput);

        // Display AI response
        chatDisplay.innerHTML += `<p>DVAI: ${aiResponse}</p>`;

        // Clear the input field
        document.getElementById("user-input").value = "";
    }

    // Function to call OpenAI API
    async function getChatGPTResponse(userInput) {
        const apiUrl = "https://api.openai.com/v1/engines/gpt-3.5-turbo-1106/completions";

        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${apiKey}`,
                },
                body: JSON.stringify({
                    prompt: userInput,
                    max_tokens: 150,  // Adjust as needed,
                }),
            });

            if (!response.ok) {
                throw new Error(`API request failed with status: ${response.status}`);
            }

            const data = await response.json();
            return data.choices[0].text.trim();
        } catch (error) {
            console.error("Error in API request:", error);

            if (error.message.includes("429")) {
                return "The assistant is currently busy. Please try again in a moment.";
            }

            return "An error occurred while processing your request.";
        }
    }
</script>

</body>
</html>
