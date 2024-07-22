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

        const options = {
            method: "POST",
            url: "https://chatgpt-gpt4-5.p.rapidapi.com/ask",
            headers: {
                "x-rapidapi-key":
                    "0076122529mshc1bfa1743700bffp1de4a1jsn399f9fef4fb5",
                "x-rapidapi-host": "chatgpt-gpt4-5.p.rapidapi.com",
                "Content-Type": "application/json",
            },
            data: {
                query:
                    JSON.stringify(results) +
                    " help me do analysis about the search result, select the most recommended service for user",
            },
        };

        try {
            const response = await axios.request(options);
            console.log("API response:", response.data);

            // Update state with chat response
            this.setState({ chatResponse: response.data.response }); // Adjust based on API response structure
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
                            {/* Add more fields as needed */}
                        </li>
                    ))}
                </ul>
                {chatResponse && (
                    <div>
                        <h2>ChatGPT Response:</h2>
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
