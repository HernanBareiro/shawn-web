#include "legacyapps/simple_app/simple_app_processor.h"
#ifdef ENABLE_SIMPLE_APP

#include "legacyapps/simple_app/simple_app_message.h"
#include "sys/simulation/simulation_controller.h"
#include "sys/node.h"
#include <iostream>


namespace simple_app
{
   SimpleAppProcessor::
   SimpleAppProcessor()
   {}

   SimpleAppProcessor::
   ~SimpleAppProcessor()
   {}
   
   void
   SimpleAppProcessor::
   boot( void )
      throw()
   {}
   
   bool
   SimpleAppProcessor::
   process_message( const shawn::ConstMessageHandle& mh ) 
      throw()
   {
      const SimpleAppMessage* msg = 
          dynamic_cast<const SimpleAppMessage*>( mh.get() );

      if( msg != NULL )
      { 
         if( owner() != msg->source() )
         { 
            /*neighbours_.insert( &msg->source() );
            INFO( logger(), "Nodo ID: "<< owner().label()<< " Recibió un mensaje de '" 
                            << msg->source().label() 
                            << "'" );*/
		neighbours_.insert( &msg->source() );
			    INFO( logger(), "Recibió un mensaje de '" 
				            << msg->source().label() 
				            << "'" );
         }
         return true;
      }

      return Processor::process_message( mh );
   }
   
   void
   SimpleAppProcessor::
   work( void )
      throw()
   {
      // send message only in the first simulation round
      if ( simulation_round() == 0 )
      { 
         send( new SimpleAppMessage );
      }
   }
}
#endif
