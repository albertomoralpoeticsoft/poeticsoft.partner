
import immutableUpdate from 'immutable-update'

const { 
  useReducer
} = wp.element

export default () => {

  const initialstate = {

  }
  
  return useReducer(    
    (state, action) => {

      let newState

      switch(action.type) {

        default:

          newState = immutableUpdate(
            state,
            action
          )
          
          return newState
      }
    },
    initialstate
  )
}