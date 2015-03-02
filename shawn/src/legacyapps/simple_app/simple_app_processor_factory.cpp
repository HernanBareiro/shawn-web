#include "_legacyapps_enable_cmake.h"
#ifdef ENABLE_SIMPLE_APP

#include "legacyapps/simple_app/simple_app_processor_factory.h"
#include "legacyapps/simple_app/simple_app_processor.h"
#include "sys/processors/processor_keeper.h"
#include "sys/simulation/simulation_controller.h"
#include <iostream>

using namespace std;
using namespace shawn;

namespace simple_app
{
   void
   SimpleAppProcessorFactory::
   register_factory( SimulationController& sc )
      throw()
   {
      sc.processor_keeper_w().add( new SimpleAppProcessorFactory );
   }
   
   SimpleAppProcessorFactory::
   SimpleAppProcessorFactory()
   {
      //cout << "SimpleAppProcessorFactory ctor" << &auto_reg_ << endl;
   }
   
   SimpleAppProcessorFactory::
   ~SimpleAppProcessorFactory()
   {
      //cout << "SimpleAppProcessorFactory dtor" << endl;
   }
   
   std::string
   SimpleAppProcessorFactory::
   name( void )
      const throw()
   { 
	   return "simple_app"; 
   }
   
   std::string 
   SimpleAppProcessorFactory::
   description( void )
      const throw()
   {
      return "simple HelloWorld demo processor";
   }
   
   shawn::Processor*
   SimpleAppProcessorFactory::
   create( void )
      throw()
   {
      return new SimpleAppProcessor;
   }

}

#endif
