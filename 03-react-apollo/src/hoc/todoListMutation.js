import gql from 'graphql-tag';
import { graphql } from 'react-apollo';
import { compose, withHandlers, withState, mapProps } from 'recompose';

const mutation = gql`
    mutation updateTodoList($id: String, $input: TodoListInput) {
        updateTodoList(id:$id, input:$input) {
            errors
            entity{
                ...on TodoListEntity{
                    name
                    state
                }
            }
        }
    }
`

export const todoListMutation = compose(
    graphql(mutation),
    withState('originState', 'setOriginState', 0),
    withHandlers({
        completeTodoList: ({ mutate, id, state, originState, setOriginState }) => event => {
            // TODO find a better way of marrying withState originState and previous state prop
            if (originState !== state) {
                setOriginState(state)
                originState = state;
            }
            mutate({
                variables: {
                    id,
                    input: { 
                        state: (originState === "1") ? "-1" : "1"
                    },
                },
            }).then(({ data: { updateTodoList: { entity: { state } }}}) => {
                console.log('[todoListMutation] State', state);
                setOriginState(state);
            }).catch(err => {
                console.error(err);
            });
        }
    }),
    mapProps(({ originState, ...props }) => ({ state: originState, ...props })),
)