import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";

export default class Chatgpt extends Component {
    constructor(props) {
        super(props);
        this.state = {
            results: [], // Initialize results state
            chatResponse: null, // Initialize chat response state
        };
    }

    async componentDidMount() {
        // Retrieve results from data attribute
        const resultsData = document.getElementById("chatgpt").dataset.results;

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

    async sendToChatGPT(results) {
        // Prepare the messages for the ChatGPT API

        //TODO:remember to assign the data in here const nessage based on the api given

        // const message =[

        // ]

        const options = {
            method: "POST",
            url: "https://open-ai34.p.rapidapi.com/v1/chat/completions",
            headers: {
                "x-rapidapi-key":
                    "0076122529mshc1bfa1743700bffp1de4a1jsn399f9fef4fb5",
                "x-rapidapi-host": "open-ai34.p.rapidapi.com",
                "Content-Type": "application/json",
            },
            data: {
                model: "Qwen/Qwen2-72B-Instruct",
                messages: [
                    {
                        content: "Hi there!",
                        role: "user",
                    },
                ],
                max_new_tokens: 1,
                temperature: 0.2,
                top_p: 0.7,
                top_k: 50,
                repetition_penalty: 1,
                stop: ["<|im_start|>", "<|im_end|>"],
            },
        };

        try {
            const response = await axios.request(options);
            console.log("Chatgpt response:", response.data);

            // Update state with chat response
            this.setState({ chatResponse: response.data.content });
        } catch (error) {
            console.error("Error sending message to ChatGPT:", error);
        }
    }

    render() {
        const { results, chatResponse } = this.state;

        return (
            <div className="container">
                <h1>ChatGPT Results:</h1>
                <ul>
                    {results.map((result, index) => (
                        <li key={index}>
                            <div>
                                <strong>Title:</strong> {result.title}
                            </div>
                            <div>
                                <strong>Price:</strong> {result.price}
                            </div>
                            <div>
                                <strong>Gig Count:</strong> {result.gigs_count}
                            </div>
                        </li>
                    ))}
                </ul>
                {chatResponse && (
                    <div className="chat-response">
                        <h2>ChatGPT Result:</h2>
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
