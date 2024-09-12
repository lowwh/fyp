import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";

export default class Chatgpt extends Component {
    constructor(props) {
        super(props);
        this.state = {
            results: [], // Initialize results state
            chatResponse: null, // Initialize chat response state
            question: "",
        };
    }

    async componentDidMount() {
        // Retrieve results from data attribute
        const analysisLoadingIcon = document.getElementById(
            "analysisLoadingIcon"
        );
        const resultsData = document.getElementById("chatgpt").dataset.results;
        const questionInput = document.getElementById("questionInput");
        const sendQuestionButton =
            document.getElementById("sendQuestionButton");

        sendQuestionButton.addEventListener("click", () => {
            const question = questionInput.value.trim(); // Get and trim the input value
            if (question === "") {
                alert("Please enter a question.");
                return;
            }
            analysisLoadingIcon.style.display = "inline-block";

            this.setState({ question: questionInput.value }, () => {
                this.sendToChatGPT();
            });
        });

        try {
            // Parse JSON-encoded results and set state
            const results = JSON.parse(resultsData);
            console.log("Parsed results:", results); // Log parsed results
            this.setState({ results });

            // Send the results to the ChatGPT API
            await this.sendToChatGPT(results);
        } catch (error) {
            console.error("Error parsing results:", error);
        }
    }

    async sendToChatGPT() {
        const { question, results } = this.state;

        // Mock response for testing purposes
        const mockResponse = {
            response: `Hi, how can I assist you today?: ${JSON.stringify(
                results
            )} ${question}`,
        };

        try {
            // Simulate an API call delay with setTimeout
            const simulatedApiCall = new Promise((resolve) => {
                setTimeout(() => {
                    resolve(mockResponse);
                }, 1000); // Simulate 1 second delay
            });

            const response = await simulatedApiCall;
            console.log("API response:", response);

            // Update state with the mock chat response
            this.setState({ chatResponse: response.response });

            // Hide the spinner
            const analysisLoadingIcon = document.getElementById(
                "analysisLoadingIcon"
            );
            if (analysisLoadingIcon) {
                analysisLoadingIcon.style.display = "none"; // Hide the spinner
            }
        } catch (error) {
            console.error("Error sending message to ChatGPT:", error);

            // Ensure spinner is hidden in case of error
            const analysisLoadingIcon = document.getElementById(
                "analysisLoadingIcon"
            );
            if (analysisLoadingIcon) {
                analysisLoadingIcon.style.display = "none";
            }
        }
    }

    render() {
        const { results, chatResponse } = this.state;

        return (
            <div className="container">
                {chatResponse && (
                    <div>
                        <h2>AI Response:</h2>
                        <p>{chatResponse}</p>
                    </div>
                )}
            </div>
        );
    }
}

if (document.getElementById("chatgpt")) {
    ReactDOM.render(<Chatgpt />, document.getElementById("chatgpt"));
}
