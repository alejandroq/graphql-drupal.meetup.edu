import React from 'react';
import FlexView from 'react-flexview';
import { branch, compose, renderComponent } from 'recompose';

import { todoListMutation } from '../../hoc/todoListMutation';

const isComplete = ({ state }) => state === "1";

const CompleteList = ({ id, name, completeTodoList }) => (
    <FlexView>
        <FlexView marginRight={'1em'}>
        <h2 style={{color: 'gray', textDecoration: 'line-through'}}>{name}</h2>
        </FlexView>
        <FlexView vAlignContent={'center'}>
            <div>
                <button onClick={() => completeTodoList()}>Mark as Incomplete</button>
            </div>
        </FlexView>
    </FlexView>
);

const IncompleteList = ({ id, name, completeTodoList }) => (
    <FlexView>
        <FlexView marginRight={'1em'}>
            <h2>{name}</h2>
        </FlexView>
        <FlexView vAlignContent={'center'}>
            <div>
                <button onClick={() => completeTodoList()}>Mark as Complete</button>
            </div>
        </FlexView>
    </FlexView>
);

const enhance = compose(
    todoListMutation,
    branch(isComplete, renderComponent(CompleteList), renderComponent(IncompleteList)),
);

export const TodoList = enhance();
