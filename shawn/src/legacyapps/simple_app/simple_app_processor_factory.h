#ifndef __SHAWN_APPS_LEGACYAPPS_SIMPLE_APP_PROCESSOR_FACTORY_H
#define __SHAWN_APPS_LEGACYAPPS_SIMPLE_APP_PROCESSOR_FACTORY_H
#include "_legacyapps_enable_cmake.h"
#ifdef ENABLE_SIMPLE_APP

#include "sys/processors/processor_factory.h"

namespace shawn 
{ 
    class SimulationController; 
    class Processor;
}

namespace simple_app
{

   class SimpleAppProcessorFactory
      : public shawn::ProcessorFactory
   {
   public:
      SimpleAppProcessorFactory();
      virtual ~SimpleAppProcessorFactory();

      virtual std::string name( void ) const throw();
      virtual std::string description( void ) const throw();
      virtual shawn::Processor* create( void ) throw();

      static void register_factory( shawn::SimulationController& ) throw();
   };

}

#endif
#endif
