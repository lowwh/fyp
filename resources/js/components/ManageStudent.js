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

export default class ManageStudent extends Component {
    constructor() {
        super();
        this.state = {
            students: [],

            studentdata: { name: "", email: "", gender: "", age: "" },

            updatemodal: false,
            updatedata: { id: "", name: "", email: "", gender: "", age: "" },
        };
    }

    toggleupdatemodal() {
        this.setState({
            updatemodal: !this.state.updatemodal,
        });
    }

    updatemodal(id, name, age, gender, email) {
        this.setState({
            updatedata: { id, name, email, age, gender },
            updatemodal: !this.state.updatemodal,
        });
    }

    updatestudent() {
        let { id, name, email, age, gender } = this.state.updatedata;
        axios
            .put("http://127.0.0.1:8000/api/users/" + id, {
                name,
                age,
                gender,
                email,
            })
            .then((response) => {
                this.setState({
                    updatedata: {
                        id: "",
                        name: "",
                        email: "",
                        gender: "",
                        age: "",
                    },
                    updatemodal: !this.state.updatemodal,
                });
                this.loadstudent();
            });
    }

    deletestudent(id) {
        if (confirm("Are You Sure You Want To Proceed?")) {
            axios
                .delete("http://127.0.0.1:8000/api/user/" + id, {})
                .then((response) => {
                    this.loadstudent();
                });
        }
    }

    loadstudent() {
        axios.get("http://127.0.0.1:8000/api/users").then((response) => {
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
                    <td>
                        <Button
                            color="success"
                            onClick={this.updatemodal.bind(
                                this,
                                student.id,
                                student.name,
                                student.age,
                                student.gender,
                                student.email
                            )}
                        >
                            Edit
                        </Button>
                        <Button
                            color="danger"
                            onClick={this.deletestudent.bind(this, student.id)}
                        >
                            Delete
                        </Button>
                    </td>
                </tr>
            );
        });
        return (
            <div className="container">
                <Modal
                    isOpen={this.state.updatemodal}
                    toggle={this.toggleupdatemodal.bind(this)}
                >
                    <ModalHeader toggle={this.toggleupdatemodal.bind(this)}>
                        Update Student Details
                    </ModalHeader>

                    <ModalBody>
                        <FormGroup>
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                value={this.state.updatedata.name}
                                onChange={(e) => {
                                    let { updatedata } = this.state;
                                    updatedata.name = e.target.value;
                                    this.setState({ updatedata });
                                }}
                            ></Input>
                        </FormGroup>
                        <FormGroup>
                            <Label for="age">Age</Label>
                            <Input
                                id="age"
                                value={this.state.updatedata.age}
                                onChange={(e) => {
                                    let { updatedata } = this.state;
                                    updatedata.age = e.target.value;
                                    this.setState({ updatedata });
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
                                value={this.state.updatedata.gender}
                                onChange={(e) => {
                                    let { updatedata } = this.state;
                                    updatedata.gender = e.target.value;
                                    this.setState({ updatedata });
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
                                value={this.state.updatedata.email}
                                onChange={(e) => {
                                    let { updatedata } = this.state;
                                    updatedata.email = e.target.value;
                                    this.setState({ updatedata });
                                }}
                            ></Input>
                        </FormGroup>
                    </ModalBody>

                    <ModalFooter>
                        <Button
                            color="primary"
                            onClick={this.updatestudent.bind(this)}
                        >
                            Add
                        </Button>

                        <Button
                            color="secondary"
                            onClick={this.toggleupdatemodal.bind(this)}
                        >
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
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

if (document.getElementById("manage")) {
    ReactDOM.render(<ManageStudent />, document.getElementById("manage"));
}
