const { 
  useEffect
} = wp.element

const { 
  TabPanel
} = wp.components

import State from './state'
import Contents from './contents'
import Groups from './groups'
import Program from './program'

export default props => {

  const [ state, dispatch ] = State()

  useEffect(() => {

    fetch('https://poeticsoft.com/wp-json/poeticsoft/manager/partner/data')
    .then(
      result => result
      .json()
      .then(
        partnerdata => {

          dispatch(partnerdata)
        }
      )
    )

    fetch('https://poeticsoft.com/wp-json/poeticsoft/partner/post/list')
    .then(
      result => result
      .json()
      .then(
        postlist => {

          dispatch({
            type: 'POST_LIST_CLASSIFY',
            payload: postlist
          })
        }
      )
    )

  }, []) 
 
  return <TabPanel
    className="PoeticsoftPartnersTools"
    activeClass="Active"
    initialTabName="contents"
    tabs={[
      {
          name: 'contents',
          title: 'Contenido'
      },
      {
          name: 'groups',
          title: 'Grupos'
      },
      {
          name: 'programacion',
          title: 'Programación'
      },
    ]}
  >
    { 
      tab => <>
        {
          tab.name == 'contents' &&
          <Contents state={ state } dispatch={ dispatch } />
        }
        {
          
          tab.name == 'groups' &&            
          <Groups state={ state } dispatch={ dispatch } />
        }
        {
          
          tab.name == 'programacion' &&            
          <Program state={ state } dispatch={ dispatch } />
        }
      </> 
    }
  </TabPanel>
}
