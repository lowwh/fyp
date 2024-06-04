import React, { Component } from "react";
import ReactDOM from "react-dom";
import {
    Table,
    Button,
    FormGroup,
    Modal,
    ModalHeader,
    ModalFooter,
    ModalBody,
    Label,
    Input,
} from "reactstrap";
import axios from "axios";

export default class AddStudent extends Component {
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
    componentWillMount() {
        this.loadstudent();
    }
    render() {
        let studentss = this.state.students.map((student) => {
            return (
                <tr key={student.id}>
                    <td>{student.id}</td>
                    <td>{student.name}</td>
                    <td>{student.age}</td>
                    <td>{student.gender}</td>
                    <td>{student.email}</td>
                </tr>
            );
        });
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <Table>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>{studentss}</tbody>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById("freelancer")) {
    ReactDOM.render(<AddStudent />, document.getElementById("freelancer"));
}
