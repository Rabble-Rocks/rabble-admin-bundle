import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import React, {Fragment, useState} from 'react';
import ReactDOM from 'react-dom';
import MutationObserver from 'mutation-observer';
import 'react-bootstrap-typeahead/css/Typeahead.css';

const AutoComplete = (props) => {
    const [isLoading, setIsLoading] = useState(false);
    const [options, setOptions] = useState([]);
    const currentState = props.currentId ? {id: props.currentId} : {id: ''};
    const [state, setState] = useState(currentState);

    const handleSearch = (query) => {
        setIsLoading(true);

        fetch(`${props.resolver}?q=${query}`)
            .then((resp) => resp.json())
            .then(({results}) => {
                const options = results.map((i) => ({
                    id: i.value,
                    text: i.text,
                }));

                setOptions(options);
                setIsLoading(false);
            });
    };
    const handleChange = (selected) => {
        setState({id: ''});
        if (selected.length > 0) {
            setState({id: selected[0].id});
        }
    };
    const filterBy = () => true;

    return (
        <Fragment>
            <input
                className="form-control"
                type="hidden"
                value={state.id}
                name={props.name}
                onChange={e => setState({id: e.target.value})}
            />
            <AsyncTypeahead
                filterBy={filterBy}
                id={props.id}
                isLoading={isLoading}
                labelKey="text"
                minLength={2}
                onSearch={handleSearch}
                onChange={handleChange}
                defaultInputValue={props.currentText ? props.currentText : ''}
                options={options}
                placeholder="Search..."
                renderMenuItemChildren={(option, props) => (
                    <Fragment>
                        <span>{option.text}</span>
                    </Fragment>
                )}
            />
        </Fragment>
    );
};

export default (function () {
    let observer = new MutationObserver(function () {
        let fields = document.getElementsByClassName("autocomplete");
        for (let i = 0; i < fields.length; i++) {
            let item = fields.item(i);
            let element = document.createElement('div');
            item.insertAdjacentElement('afterend', element);
            ReactDOM.render((
                <AutoComplete name={item.name} resolver={item.dataset.resolver} currentId={item.value} id={item.id}
                              currentText={item.dataset.currentText}/>
            ), element);
            item.remove();
        }
    });
    observer.observe(document, {
        subtree: true,
        childList: true,
        attributes: false
    });
});