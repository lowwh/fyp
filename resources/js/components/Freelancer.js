import React, { Component } from "react";
import ReactDOM from "react-dom";
import {
    Container,
    Modal,
    ModalHeader,
    ModalBody,
    FormGroup,
    Label,
    Input,
    Button,
    Table,
} from "reactstrap";
import axios from "axios";

export default class Freelancer extends Component {
    constructor() {
        super();
        this.state = {
            students: [],
            profilemodal: false,
            profiledata: { main_id: "", name: "" },
        };
        // Bind getprofiledata in the constructor
    }

    loadstudent() {
        axios.get("http://127.0.0.1:8000/api/students").then((response) => {
            this.setState({
                students: response.data,
            });
        });
    }

    getprofiledata() {
        console.log("getprofiledata called with id:");
        // this.setState({
        //     profiledata: { main_id, name },
        //     profilemodal: !this.state.profilemodal,
        // });
    }

    componentWillMount() {
        this.loadstudent();
    }

    toggleprofilemodal = () => {
        this.setState({
            profilemodal: !this.state.profilemodal,
        });
    };

    render() {
        let studentData = this.state.students.map((student) => (
            <tr>
                <td>{student.main_id}</td>
                <td>{student.name}</td>
                <td>{student.age}</td>
                <td>{student.gender}</td>
                <td>{student.email}</td>
                <td key={student.main_id}>
                    <Button
                        color="primary"
                        onClick={this.getprofiledata.bind(
                            this,
                            student.main_id,
                            student.name
                        )}
                    >
                        View Profile
                    </Button>
                    <Button
                        color="primary"
                        onClick={this.getprofiledata.bind(this)}
                    >
                        View Profile
                    </Button>
                </td>
            </tr>
        ));

        return (
            <div className="container">
                <Modal
                    isOpen={this.state.profilemodal}
                    toggle={this.toggleprofilemodal.bind(this)}
                >
                    <ModalHeader
                        toggle={this.toggleprofilemodal.bind(this)}
                    ></ModalHeader>
                    <ModalBody>
                        <FormGroup>
                            <Label for="id" name="id">
                                Id:
                            </Label>
                            <Input
                                type="text"
                                id="id"
                                value={this.state.profiledata.main_id}
                                onChange={(e) => {
                                    let { profiledata } = this.state;
                                    profiledata.id = e.target.value;
                                    this.setState({ profiledata });
                                }}
                            ></Input>
                        </FormGroup>
                        <FormGroup>
                            <Label for="name">Service:</Label>
                            <Input
                                id="name"
                                value={this.state.profiledata.name}
                                onChange={(e) => {
                                    let { profiledata } = this.state;
                                    profiledata.name = e.target.value;
                                    this.setState({ profiledata });
                                }}
                            ></Input>
                        </FormGroup>
                    </ModalBody>
                </Modal>
                <Table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>{studentData}</tbody>
                </Table>
            </div>
        );
    }
}

if (document.getElementById("freelancer")) {
    ReactDOM.render(<Freelancer />, document.getElementById("freelancer"));
}
