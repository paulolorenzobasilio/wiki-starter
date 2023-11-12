import React, {useEffect, useState} from 'react';
import axios from "axios";
import {createRoot} from "react-dom/client";

function App(){
    const url = "http://localhost:8000"
    const initialFormData = {
        title: "",
        description: ""
    }
    const [data, setData] = useState([])
    const [formData, setFormData] = useState(initialFormData)

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.id]: e.target.value });
    };

    const clearFormData = () => {
        setFormData({...initialFormData})
        editor.root.innerHTML = ''
    }

    const handleSubmit = async (e) => {
        e.preventDefault()

        // for getting the contents with html tags in quill editor
        if(editor.getText().trim()){
            formData.description = editor.root.innerHTML
        }

        await axios.post(url, formData, {
            headers: {'Content-Type': `multipart/form-data`}
        }).then((r) => {
            alert('Success')
            setData((data) => [...data, r.data])
            clearFormData()
        }).catch((error) => {
            const response = error.response
            if(response.status === 400){
                for (const [key, value] of Object.entries(response.data)){
                    alert(value)
                }
            }
        })
    }

    const onDelete = async (id) => {
        await axios.delete(`${url}/${id}`, {
            headers: {
                'Content-Type': `application/json`
            }
        }).then(() => {
            setData(data.filter(d => d.id !== id))
        }).catch((error) => {
            console.error(error)
            alert('Error!')
        })
    }

    useEffect(() => {
        axios.get(url).then((response) => setData(response.data))
    }, []);

    return (
        <div className={"container"}>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label">Title</label>
                    <input id="title" type="text" className="form-control"
                           placeholder="Enter wiki title..."
                           value={formData.title}
                           onChange={handleChange}
                           required
                           maxLength="75"/>
                </div>
                <div className="mb-3">
                    <label className="form-label">Description</label>
                    <div id="description" className={"quill-editor"}/>
                </div>
                <button className={"btn btn-primary"} type={"submit"}>Submit</button>
            </form>
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
        </div>
    );
}
const root = createRoot(document.getElementById('root'))
root.render(<App/>)
