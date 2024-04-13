import React, { Component } from "react";
import ReactDOM from "react-dom";
import {
    Table,
    Button,
    Card,
    CardBody,
    CardTitle,
    CardText,
    Modal,
    ModalHeader,
    ModalBody,
    ModalFooter,
    FormGroup,
    Label,
    Input
} from "reactstrap";
import axios from "axios";

export default class ManageResult extends Component {
    constructor() {
        super();
        this.state = {
            results: [],
            students: [], 
            showDetails: {},
            deleteResultId: null,
            deleteConfirmationModal: false
        };
    }

    loadResults() {
        axios.get("http://127.0.0.1:8000/api/results").then((response) => {
            this.setState({
                results: response.data,
            });
        });
    }

    loadStudents() {
        axios.get("http://127.0.0.1:8000/api/students").then((response) => {
            this.setState({
                students: response.data,
            });
        });
    }

    toggleDetails(studentId) {
        const { showDetails } = this.state;
        showDetails[studentId] = !showDetails[studentId];
        this.setState({
            showDetails: showDetails
        });
    }

    handleUpdateResult(resultId) {
        const newResultScore = prompt("Enter the new result score:");
        if (newResultScore !== null) {
            axios.put(`http://127.0.0.1:8000/api/results/${resultId}`, {
                result_score: newResultScore
            }).then(response => {
                alert("Result updated successfully");
                this.loadResults();
            }).catch(error => {
                console.error("Error updating result:", error);
                alert("Error updating result. Please try again.");
            });
        }
    }

    toggleDeleteConfirmationModal(resultId = null) {
        this.setState(prevState => ({
            deleteResultId: resultId,
            deleteConfirmationModal: !prevState.deleteConfirmationModal
        }));
    }

    handleDeleteResult() {
        const { deleteResultId } = this.state;
        axios.delete(`http://127.0.0.1:8000/api/results/${deleteResultId}`)
            .then(response => {
                alert("Result deleted successfully");
                this.loadResults();
                this.toggleDeleteConfirmationModal();
            }).catch(error => {
                console.error("Error deleting result:", error);
                alert("Error deleting result. Please try again.");
            });
    }

    componentDidMount() {
        this.loadResults();
        this.loadStudents();
    }

    render() {
        const { results, students, showDetails, deleteConfirmationModal } = this.state;

        const uniqueStudentIds = [...new Set(results.map(result => result.student_id))];

        const studentRows = uniqueStudentIds.map((studentId, index) => {
            const studentResults = results.filter(result => result.student_id === studentId);
            return (
                <tr key={index}>
                    <td>{studentResults[0].id}</td>
                    <td>{studentId}</td>
                    <td>{studentResults[0].name}</td>
                    <td>
                        <Button color="primary" onClick={() => this.toggleDetails(studentId)}>
                            {showDetails[studentId] ? "Show Less" : "Show More"}
                        </Button>
                    </td>
                </tr>
            );
        });

        const detailCards = results.map((result, index) => {
            if (showDetails[result.student_id]) {
                return (
                    <Card key={index}>
                        <CardBody>
                            <CardTitle>ID: {result.id}</CardTitle>
                            <CardText>Student ID: {result.student_id}</CardText>
                            <CardText>Name: {result.name}</CardText>
                            <CardText>Courses: {result.course}</CardText>
                            <CardText>Result Score: {result.result_score}</CardText>
                            <Button color="info" onClick={() => this.handleUpdateResult(result.id)}>Update</Button>
                            <Button color="danger" onClick={() => this.toggleDeleteConfirmationModal(result.id)}>Delete</Button>
                        </CardBody>
                    </Card>
                );
            }
        });

        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <Table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>{studentRows}</tbody>
                            </Table>
                        </div>
                        {detailCards}
                        <Modal isOpen={deleteConfirmationModal} toggle={() => this.toggleDeleteConfirmationModal()}>
                            <ModalHeader toggle={() => this.toggleDeleteConfirmationModal()}>Delete Result</ModalHeader>
                            <ModalBody>
                                Are you sure you want to delete this result?
                            </ModalBody>
                            <ModalFooter>
                                <Button color="danger" onClick={() => this.handleDeleteResult()}>Yes</Button>{' '}
                                <Button color="secondary" onClick={() => this.toggleDeleteConfirmationModal()}>No</Button>
                            </ModalFooter>
                        </Modal>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById("ManageResult")) {
    ReactDOM.render(<
ManageResult />, document.getElementById("ManageResult"));
}
