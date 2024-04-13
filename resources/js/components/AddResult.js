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

export default class AddResult extends Component {
    constructor() {
        super();
        this.state = {
            results: [],
            students: [], 
            showDetails: {},
            addResultModal: false,
            selectedStudentId: "",
            selectedCourse: "",
            resultScores: {} 
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

    toggleAddResultModal() {
        this.setState(prevState => ({
            addResultModal: !prevState.addResultModal
        }));
    }

    handleStudentIdChange(event) {
        this.setState({
            selectedStudentId: event.target.value
        });
    }

    handleCourseChange(event) {
        this.setState({
            selectedCourse: event.target.value
        });
    }

    handleResultScoreChange(event, course) {
        const { resultScores } = this.state;
        resultScores[course] = event.target.value;
        this.setState({
            resultScores: resultScores
        });
    }

    handleAddResult() {
        const { selectedStudentId, selectedCourse, resultScores } = this.state;
        axios.post("http://127.0.0.1:8000/api/result", {
            student_id: selectedStudentId,
            course: selectedCourse,
            result_score: resultScores[selectedCourse]
        }).then(response => {
            alert("Result added successfully");
            this.loadResults();
            this.toggleAddResultModal();
        }).catch(error => {
            if (error.response && error.response.status === 400 && error.response.data.error) {
                alert(error.response.data.error); // Display error message
            } else {
                console.error("Error adding result:", error);
            }
        });
    }
    

    componentDidMount() {
        this.loadResults();
        this.loadStudents();
    }

    render() {
        const { results, students, showDetails, addResultModal, selectedStudentId, selectedCourse, resultScores } = this.state;

        const studentIdOptions = students.map(student => (
            <option key={student.student_id} value={student.student_id} style={{ color: "blue" }}>{student.student_id}</option>
        ));

        const coursesOptions = ["Chemistry", "Mathematics", "Fundamentals of Programming", "Project Management"];

        const courseOptions = coursesOptions.map(course => (
            <option key={course} value={course}>{course}</option>
        ));

        const resultScoreInputs = (
            <FormGroup>
                <Label for={`resultScore_${selectedCourse}`}>{selectedCourse} Result Score</Label>
                <Input
                    type="number"
                    name={`resultScore_${selectedCourse}`}
                    id={`resultScore_${selectedCourse}`}
                    value={resultScores[selectedCourse] || ""}
                    onChange={(e) => this.handleResultScoreChange(e, selectedCourse)}
                />
            </FormGroup>
        );

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
                        <Button color="primary" onClick={this.toggleAddResultModal.bind(this)}>Add Result</Button>
                        <Modal isOpen={addResultModal} toggle={this.toggleAddResultModal.bind(this)}>
                            <ModalHeader toggle={this.toggleAddResultModal.bind(this)}>Add Result</ModalHeader>
                            <ModalBody>
                                <FormGroup>
                                    <Label for="selectStudentId">Select Student ID</Label>
                                    <Input type="select" name="selectStudentId" id="selectStudentId" value={selectedStudentId} onChange={this.handleStudentIdChange.bind(this)}>
                                        <option value="">Select Student ID</option>
                                        {studentIdOptions}
                                    </Input>
                                </FormGroup>
                                <FormGroup>
                                    <Label for="selectCourse">Select Course</Label>
                                    <Input type="select" name="selectCourse" id="selectCourse" value={selectedCourse} onChange={(e) => this.handleCourseChange(e)}>
                                        <option value="">Select Course</option>
                                        {courseOptions}
                                    </Input>
                                </FormGroup>
                                {resultScoreInputs}
                            </ModalBody>
                            <ModalFooter>
                                <Button color="primary" onClick={this.handleAddResult.bind(this)}>Add</Button>{' '}
                                <Button color="secondary" onClick={this.toggleAddResultModal.bind(this)}>Cancel</Button>
                            </ModalFooter>
                        </Modal>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById("AddResult")) {
    ReactDOM.render(<AddResult />, document.getElementById("AddResult"));
}
