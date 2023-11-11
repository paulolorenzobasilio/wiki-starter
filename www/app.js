import React from 'react';
import ReactDOM from 'react-dom'

function App(){
    return (
        <div className={"container"}>
            <div className="mb-3">
                <label className="form-label">Title</label>
                <input type="text" className="form-control" id="tile" placeholder="Enter wiki title..."/>
            </div>
            <div className="mb-3">
                <label className="form-label">Description</label>
                <div id="description" className={"quill-editor"}></div>
            </div>
            <button className={"btn btn-primary"}>Submit</button>
        </div>
    );
}

ReactDOM.render(<App/>, document.getElementById('root'))
