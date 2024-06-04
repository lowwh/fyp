import React, { Component } from "react";
import ReactDOM from "react-dom";
import {
    Container,
    Row,
    Col,
    Card,
    CardBody,
    CardTitle,
    CardText,
} from "reactstrap";
import axios from "axios";
import StudentCard from "./StudentCard";

export default class Freelancer extends Component {
    constructor() {
        super();
        this.state = {
            students: [],
            studentmodal: false,
            studentdata: { name: "", email: "", gender: "", age: "" },
            errors: {},
        };
    }

    loadstudent() {
        axios.get("http://127.0.0.1:8000/api/students").then((response) => {
            this.setState({
                students: response.data,
            });
        });
    }

    componentDidMount() {
        this.loadstudent();
    }

    render() {
        let studentCards = this.state.students.map((student) => {
            return (
                <Col key={student.id} style={{ flex: "0 0 15%" }}>
                    {" "}
                    {/* Adjust grid class as needed */}
                    <Card>
                        <CardBody style={{ maxHeight: "200px" }}>
                            {" "}
                            {/* Limit card height */}
                            <CardTitle
                                tag="h5"
                                style={{ textOverflow: "ellipsis" }}
                            >
                                {" "}
                                {/* Truncate text */}
                                {student.name}
                            </CardTitle>
                            <CardText>
                                <strong>Age:</strong> {student.age}
                                <br />
                                <strong>Gender:</strong> {student.gender}
                                <br />
                                <strong>Email:</strong> {student.email}
                            </CardText>
                        </CardBody>
                    </Card>
                </Col>
            );
        });

        return (
            <Container fluid>
                <Row
                    style={{
                        display: "flex",
                        flexDirection: "row",
                        flexWrap: "wrap",
                    }}
                >
                    {studentCards}
                </Row>
            </Container>
        );
    }
}

if (document.getElementById("freelancer")) {
    ReactDOM.render(<Freelancer />, document.getElementById("freelancer"));
}
