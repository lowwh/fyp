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

    addstudent() {
        axios
            .post("http://127.0.0.1:8000/api/student", this.state.studentdata)
            .then((response) => {
                this.setState({
                    studentdata: { name: "", email: "", gender: "", age: "" },
                    studentmodal: !this.state.studentmodal,
                });

                this.loadstudent();
            })
            .catch((error) => {
                if (error.response && error.response.data.errors) {
                    this.setState({ errors: error.response.data.errors });
                }
            });
    }

    togglestudentmodal() {
        this.setState({
            studentmodal: !this.state.studentmodal,
        });
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
                <Modal
                    isOpen={this.state.studentmodal}
                    toggle={this.togglestudentmodal.bind(this)}
                >
                    <ModalHeader toggle={this.togglestudentmodal.bind(this)}>
                        Add Student
                    </ModalHeader>

                    <ModalBody>
                        <FormGroup>
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                value={this.state.studentdata.name}
                                onChange={(e) => {
                                    let { studentdata } = this.state;
                                    studentdata.name = e.target.value;
                                    this.setState({ studentdata });
                                }}
                                placeholder="e.g.  peter"
                            ></Input>
                            {this.state.errors && this.state.errors.name && (
                                <span style={{ color: "red" }}>
                                    {this.state.errors.name[0]}
                                </span>
                            )}
                        </FormGroup>
                        <FormGroup>
                            <Label for="age">Age</Label>
                            <Input
                                id="age"
                                value={this.state.studentdata.age}
                                onChange={(e) => {
                                    let { studentdata } = this.state;
                                    studentdata.age = e.target.value;
                                    this.setState({ studentdata });
                                }}
                            ></Input>
                            {this.state.errors && this.state.errors.age && (
                                <span style={{ color: "red" }}>
                                    {this.state.errors.age[0]}
                                </span>
                            )}
                        </FormGroup>
                        <FormGroup>
                            <Label for="gender">Gender</Label>
                            <Input
                                type="select"
                                id="gender"
                                value={this.state.studentdata.gender}
                                onChange={(e) => {
                                    let { studentdata } = this.state;
                                    studentdata.gender = e.target.value;
                                    this.setState({ studentdata });
                                }}
                            >
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </Input>
                            {this.state.errors && this.state.errors.gender && (
                                <span style={{ color: "red" }}>
                                    {this.state.errors.gender[0]}
                                </span>
                            )}
                        </FormGroup>
                        <FormGroup>
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                value={this.state.studentdata.email}
                                onChange={(e) => {
                                    let { studentdata } = this.state;
                                    studentdata.email = e.target.value;
                                    this.setState({ studentdata });
                                }}
                                placeholder="e.g.  email@gmail.com"
                            ></Input>
                            {this.state.errors && this.state.errors.email && (
                                <span style={{ color: "red" }}>
                                    {this.state.errors.email[0]}
                                </span>
                            )}
                        </FormGroup>
                    </ModalBody>

                    <ModalFooter>
                        <Button
                            color="primary"
                            onClick={this.addstudent.bind(this)}
                        >
                            Add
                        </Button>

                        <Button
                            color="secondary"
                            onClick={this.togglestudentmodal.bind(this)}
                        >
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <Button
                            color="primary"
                            onClick={this.togglestudentmodal.bind(this)}
                        >
                            Add Student
                        </Button>

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

if (document.getElementById("student")) {
    ReactDOM.render(<AddStudent />, document.getElementById("student"));
}
