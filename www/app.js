import React, {useState} from 'react';
import ReactDOM from 'react-dom'
import axios from "axios";

function App(){
    const initialFormData = {
        title: "",
        description: ""
    }
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

        formData.description = editor.root.innerHTML
        try {
            const response = await axios({
                method: 'post',
                url: 'http://127.0.0.1:8000',
                data: formData,
                headers: {
                    'Content-Type': `multipart/form-data`
                }
            })
            console.log('Success', response.data)
            alert('Success')
            clearFormData()
        } catch (error){
            alert('Error')
            console.error("Error:", error)
        }

    }
    return (
        <div className={"container"}>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label">Title</label>
                    <input id="title" type="text" className="form-control"
                           placeholder="Enter wiki title..."
                           value={formData.title}
                           onChange={handleChange}/>
                </div>
                <div className="mb-3">
                    <label className="form-label">Description</label>
                    <div id="description" className={"quill-editor"}/>
                </div>
                <button className={"btn btn-primary"} type={"submit"}>Submit</button>
            </form>
        </div>
    );
}

ReactDOM.render(<App/>, document.getElementById('root'))
