import React, { Component } from "react";
import ReactDOM from "react-dom";
import { Table, Button } from "reactstrap";
import axios from "axios";

export default class Chatgpt extends Component {
    constructor(props) {
        super(props);
        this.state = {
            chatResponse: null,
            weathers: [],
            params: {
                lat: "2.9933226",
                lon: "101.7877607",
                units: "metric",
                lang: "en",
            },
        };
    }

    sendMessage() {
        const options = {
            method: "POST",
            url: "https://chatgpt-api8.p.rapidapi.com/",
            headers: {
                "x-rapidapi-key":
                    "0076122529mshc1bfa1743700bffp1de4a1jsn399f9fef4fb5",
                "x-rapidapi-host": "chatgpt-api8.p.rapidapi.com",
                "Content-Type": "application/json",
            },
            data: {
                role: "user",
                content: "compare between 5 star rating and 4 star rating",
            },
        };

        axios
            .request(options)
            .then((response) => {
                this.setState({
                    chatResponse: response.data,
                });
                console.log(response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    render() {
        return (
            <div className="container">
                <div>
                    <h1>You can ask anything in here</h1>
                    <Button color="primary" onClick={() => this.sendMessage()}>
                        Chatgpt
                    </Button>
                </div>

                {this.state.chatResponse && (
                    <div>
                        <h4>ChatGPT Response:</h4>
                        <p>{JSON.stringify(this.state.chatResponse)}</p>
                    </div>
                )}
            </div>
        );
    }
}

if (document.getElementById("chatgpt")) {
    ReactDOM.render(<Chatgpt />, document.getElementById("chatgpt"));
}
