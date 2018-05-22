import React from 'react';
import { compose } from 'recompose';

import { listsQuery } from '../../hoc/listsQuery';
import { TodoList } from '../TodoList/TodoList';

const enhance = compose(
    listsQuery
)

export const Lists = enhance(({ lists }) => (
   <React.Fragment>
       {
           lists.map(({ entityId, ...props }, i) => <TodoList id={entityId} key={i} {...props} />)
       }
   </React.Fragment>
));