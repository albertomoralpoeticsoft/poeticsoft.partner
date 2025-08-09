const { 
  SelectControl, 
  Button,
  CheckboxControl
} = wp.components
import Rule from './publishrule'

export default props => {

  return <div className="PublishRules">
    <CheckboxControl
      label="Programar publicaciones"
      help="Activar las reglas de publicación"
      checked={ true }
      onChange={
        value => props.dispatch({
          test: value
        })
      }
    />
    {
      <div className="Manage">
        <div className="Rules">
          <SelectControl
            label="Reglas de publicación"
            className="Selector"
            placeholder="titulo de la regla"
            value={ props.state.selectedRuleIndex }
            options={ 
              [
                { 
                  value: -1, 
                  label: `
                    ${
                      props.state.publishRules.length ?
                      'Selecciona una regla'
                      :
                      'Crea una regla' 
                    }
                  `
                }        
              ]
              .concat(
                props.state.publishRules
                .map(
                  (r, index) => ({
                    value: index,
                    label: r.title
                  })
                )
              )
            }
            onChange={ 
              value => props.dispatch({
                selectedRuleIndex: parseInt(value)
              }) 
            }
          />
          <Button
            variant="primary"
            onClick={ 
              () => props.dispatch({
                type: 'PUBLISH_RULES_CREATE_RULE'
              }) 
            }
          >
            +
          </Button>
          <Button
            variant="primary"
            disabled={ props.state.selectedRuleIndex == -1 }
            onClick={ 
              () => props.dispatch({
                type: 'PUBLISH_RULES_DELETE_RULE'
              }) 
            }
          >
            x
          </Button>
        </div>        
        {
          props.state.selectedRuleIndex >= 0 &&
          <Rule 
            state={ props.state }
            dispatch={ props.dispatch }
          />
        }      
      </div>
    }
  </div>
}