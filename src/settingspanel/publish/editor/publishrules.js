const { 
  SelectControl, 
  Button
} = wp.components
import Rule from './publishrule'

export default props => {

  return <div className="PublishRules">
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
            value => props.localDispatch({
              selectedRuleIndex: parseInt(value)
            }) 
          }
        />
        <Button
          variant="primary"
          onClick={ 
            () => props.localDispatch({
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
            () => props.localDispatch({
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
          meta={ props.meta }
          setMeta={ props.setMeta }
          state={ props.state }
          localDispatch={ props.localDispatch }
        />
      }      
    </div>
  </div>
}