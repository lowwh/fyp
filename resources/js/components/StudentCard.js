// resources/js/components/StudentCard.js
import React from "react";
import { Card, CardBody, CardTitle, CardText } from "reactstrap";

const StudentCard = ({ student }) => {
    return (
        <Card className="mb-3">
            <CardBody>
                <CardTitle tag="h5">{student.name}</CardTitle>
                <CardText>
                    <strong>Age:</strong> {student.age}
                    <br />
                    <strong>Gender:</strong> {student.gender}
                    <br />
                    <strong>Email:</strong> {student.email}
                </CardText>
            </CardBody>
        </Card>
    );
};

export default StudentCard;
