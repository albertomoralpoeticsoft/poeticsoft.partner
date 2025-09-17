import immutableUpdate from 'immutable-update'
const { 
  useReducer
} = wp.element

export default () => {

  const initialsetate = {

    admindata: poeticsoft_partner_admin_data,

    user: null,
    post: null,

    postchanged: false,

    publishwhat: [],
    publishnowwhat: null,
    publishtags: false,

    publishwhere: [],
    publishnowwhere: [],

    publishing: false,
    message: ''
  }
  
  return useReducer(    
    (state, action) => {

      let newState

      switch(action.type) {  
        
        case 'PUBLISH_DATA_SET':

          newState = immutableUpdate(
            state,
            {
              publishwhat: action.payload.postpublishwhat,
              publishnowwhat: action.payload.postpublishwhat[0].value,
              publishwhere: action.payload.destinations
              .map(d => ({
                label: d,
                value: d
              }))
            }
          )

          return newState

        default:

          newState = immutableUpdate(
            state,
            action
          )
          
          return newState
      }
    },
    initialsetate
  )
}