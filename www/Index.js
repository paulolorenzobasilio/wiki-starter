import React, {useEffect, useState} from 'react';
import axios from "axios";

export default function Index(){
    const url = "http://127.0.0.1:8000"
    const [data, setData] = useState([])
    const fetchInfo = () => {
        return axios.get(url).then((response) => setData(response.data))
    }
    const onDelete = async (id) => {
        try {
            await axios.delete(`${url}/${id}`, {
                headers: {
                    'Content-Type': `application/json`
                }
            });
            setData(data.filter(d => d.id !== id))
        } catch (error){
            console.error(error)
            alert('Error!')
        }
    }

    useEffect(() => {
        fetchInfo();
    }, []);

    return (
        <table className="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Url</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            {data.map((item, index) => {
                return (
                    <tr key={index}>
                        <th scope="row">{++index}</th>
                        <td>{item.title}</td>
                        <td>{item.description}</td>
                        <td>{item.url}</td>
                        <td>
                            <button className={"btn btn-danger"} type={"button"} onClick={() => onDelete(item.id)}>Delete</button>
                        </td>
                    </tr>
                )
            })}
            </tbody>
        </table>
    )
}
