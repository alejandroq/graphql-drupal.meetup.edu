import React from 'react';
import { graphql } from 'react-apollo';
import gql from 'graphql-tag';
import { compose, branch, renderComponent, mapProps } from 'recompose';

const _listsQuery = graphql(gql`
    query {
        todoListEntityQuery(filter:{}) {
            count
            entities{
                entityId
                ...on TodoListEntity{
                    name
                    state
                }
            }
        }
    }
`);

const massageLists = ({ data: { todoListEntityQuery: { entities }}}) => ({
    lists: entities,
});

const isLoading = ({ data: { loading }}) => loading;

const hasError = ({ data: { error }}) => error;

const LoadingComponent = () => <p>Loading...</p>

const ErrorComponent = ({ data: { error: { message }, ...props } }) => (
    <React.Fragment>
        <p style={{color: 'red'}}>{message}</p>
        <code>{JSON.stringify(props)}</code>
    </React.Fragment>
);

export const listsQuery = compose(
    _listsQuery,
    branch(isLoading, renderComponent(LoadingComponent)),
    branch(hasError, renderComponent(ErrorComponent)),
    branch(hasError, renderComponent(ErrorComponent)),
    mapProps(massageLists)
);