import React, { Component } from "react";
import ReactDOM from "react-dom";
import {
    Table,
    Button,
    Input,
    Modal,
    ModalHeader,
    ModalBody,
    ModalFooter,
    FormGroup,
    Label,
} from "reactstrap";
import axios from "axios";

export default class Home extends Component {
    constructor() {
        super();
        this.state = {
            posts: [],
            fmodal: false,
            fdata: { name: "" },
            smodal: false,
            sdata: { id: "", name: "" },
        };
    }

    loadpost() {
        axios.get("http://127.0.0.1:8000/api/friends").then((response) => {
            this.setState({
                posts: response.data,
            });
        });
    }
    togglefmodal() {
        this.setState({
            fmodal: !this.state.fmodal,
        });
    }

    addf() {
        axios
            .post("http://127.0.0.1:8000/api/friend", this.state.fdata)
            .then((response) => {
                this.setState({
                    fmodal: !this.state.fmodal,
                    fdata: { name: "" },
                });

                this.loadpost();
            });
    }

    show(id, name) {
        this.setState({
            smodal: !this.state.smodal,
            sdata: { id, name },
        });
    }

    togglesmodal() {
        this.setState({
            smodal: !this.state.smodal,
        });
    }
    update() {
        let { id, name } = this.state.sdata;
        axios
            .put("http://127.0.0.1:8000/api/fri/" + id, { name })
            .then((response) => {
                this.setState({
                    smodal: !this.state.smodal,
                    sdata: { id: "", name: "" },
                });

                this.loadpost();
            });
    }

    delete(id) {
        if (confirm("Do you want delete this Post?")) {
            axios
                .delete("http://127.0.0.1:8000/api/fr/" + id, {})
                .then((response) => {
                    this.loadpost();
                });
        }
    }
    componentWillMount() {
        this.loadpost();
    }
    render() {
        let post = this.state.posts.map((post) => {
            return (
                <tr>
                    <td>{post.id}</td>
                    <td>{post.name}</td>
                    <td key={post.id}>
                        <Button
                            color="success"
                            onClick={this.show.bind(this, post.id, post.name)}
                        >
                            Edit
                        </Button>
                        <Button
                            color="danger"
                            onClick={this.delete.bind(this, post.id)}
                        >
                            Delete
                        </Button>
                    </td>
                </tr>
            );
        });
        return (
            <div className="container">
                <Button color="success" onClick={this.togglefmodal.bind(this)}>
                    Add
                </Button>

                <Modal
                    isOpen={this.state.fmodal}
                    toggle={this.togglefmodal.bind(this)}
                >
                    <ModalHeader toggle={this.togglefmodal.bind(this)}>
                        Add
                    </ModalHeader>
                    <ModalBody>
                        <FormGroup>
                            <Label for="name" name="name">
                                Name:
                            </Label>
                            <Input
                                type="text"
                                id="name"
                                value={this.state.fdata.name}
                                onChange={(e) => {
                                    let { fdata } = this.state;
                                    fdata.name = e.target.value;
                                    this.setState({ fdata });
                                }}
                            ></Input>
                        </FormGroup>
                    </ModalBody>
                    <ModalFooter>
                        <Button color="primary" onClick={this.addf.bind(this)}>
                            Add
                        </Button>
                        <Button
                            color="secondary"
                            onClick={this.togglefmodal.bind(this)}
                        >
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
                <Modal
                    isOpen={this.state.smodal}
                    toggle={this.togglesmodal.bind(this)}
                >
                    <ModalHeader toggle={this.togglesmodal.bind(this)}>
                        update
                    </ModalHeader>
                    <ModalBody>
                        <FormGroup>
                            <Label for="id" name="id">
                                Id:
                            </Label>
                            <Input
                                type="text"
                                id="id"
                                value={this.state.sdata.id}
                                onChange={(e) => {
                                    let { sdata } = this.state;
                                    sdata.id = e.target.value;
                                    this.setState({ sdata });
                                }}
                            ></Input>
                            <Label for="name" name="name">
                                Name:
                            </Label>
                            <Input
                                type="text"
                                id="name"
                                value={this.state.sdata.name}
                                onChange={(e) => {
                                    let { sdata } = this.state;
                                    sdata.name = e.target.value;
                                    this.setState({ sdata });
                                }}
                            ></Input>
                        </FormGroup>
                    </ModalBody>
                    <ModalFooter>
                        <Button
                            color="primary"
                            onClick={this.update.bind(this)}
                        >
                            Add
                        </Button>
                        <Button
                            color="secondary"
                            onClick={this.togglesmodal.bind(this)}
                        >
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
                <Table>
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Name</td>
                        </tr>
                    </thead>
                    <tbody>{post}</tbody>
                </Table>
            </div>
        );
    }
}

if (document.getElementById("home")) {
    ReactDOM.render(<Home />, document.getElementById("home"));
}
