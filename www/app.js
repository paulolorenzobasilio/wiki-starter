import React from 'react';
import ReactDOM from 'react-dom'

function App(){
    return (
        <div className={"container-fluid"}>
            <div className="mb-3">
                <label className="form-label">Title</label>
                <input type="text" className="form-control" id="tile" placeholder="Enter wiki title..."/>
            </div>
            <div className="mb-3">
                <label className="form-label">Description</label>
                <textarea className="form-control" id="description"></textarea>
            </div>
        </div>
    );
}

ReactDOM.render(<App/>, document.getElementById('root'))
